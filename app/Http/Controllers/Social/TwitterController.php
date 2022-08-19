<?php

namespace App\Http\Controllers\Social;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller as BaseController;
use App\Models\User;
use App\Models\Feed;
use App\Models\SharedLink;
use App\Models\SharedDomain;
use Carbon\Carbon;
use Coderjerk\BirdElephant\BirdElephant;
use Auth;
use Log;
use Exception;
use GuzzleHttp\Exception\ClientException;

class TwitterController extends BaseController
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
   public function redirectToTwitter()
   {
       return Socialite::driver('twitter-oauth-2')->redirect();
   }

 /**
  * Create a new controller instance.
  *
  * @return void
  */
   public function handleTwitterCallback()
   {
       try {

           $user = Socialite::driver('twitter-oauth-2')->user();

           $finduser = User::where('twitter_id', $user->id)->first();

           if($finduser){

               Auth::login($finduser);

               return redirect()->intended('home');

           }else{
               $newUser = User::updateOrCreate(['email' => $user->email],[
                       'name' => $user->name,
                       'twitter_id'=> $user->id,
                       'password' => encrypt('123456dummy'),
                        'twitter_username' => $user->nickname,
                   ]);

               Auth::login($newUser);

               return redirect()->intended('home');
           }

       } catch (Exception $e) {
           dd($e->getMessage());
       }
   }
   protected function getCredential()
   {
     return config('toplink.twitter.credentials');
   }

   function linkExtractor($html)
   {
     preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $html, $match);
     return $match[0];
   }

   function getFollowing($user_name)
   {
     $credentials = $this->getCredential();
     $params = config('toplink.twitter.api.following.params');
     $twitter = new BirdElephant($credentials);
     $user = $twitter->user($user_name);
     $following = $user->following($params);
     if($following->meta->result_count >0) {
        return $following->data;
     }
     return [];
   }

   function getTweets($params)
   {
     $credentials = $this->getCredential();
     $twitter = new BirdElephant($credentials);
     $tweets = $twitter->tweets();
     $twts = $tweets->search()->recent($params);
     Log::info($params);
     $tweetsArr = [];
     $tweetsIds = [];
     $tweetsLinks = [];
     if($twts->meta->result_count >0) {
       foreach($twts->data as $k=>$twt) {
         $tweetsArr[$twt->id] = [
           'reference_id' =>$twt->id,
           'author_id' => $twt->author_id,
           'content' => $twt->text,
           'extraced_url' => '',
           'created_at' => Carbon::parse($twt->created_at)->toDateTimeString(),
           'social_type' => 'twitter',
           ];
         $tweetsIds[] =$twt->id;
         $tweetsLinks[$twt->id] = $this->linkExtractor($twt->text);
       }
     }
     return [
       'tweet_ids'=>$tweetsIds,
       'tweet_datas' => $tweetsArr,
       'tweet_links' => $tweetsLinks,
     ];
   }

   public function calculating()
   {
     $credentials = $this->getCredential();
     $user = Auth::user();
     if(!$user) {
       abort(400);
     }
     //get twitter username
     $username = $user->twitter_username;
     $params = config('toplink.twitter.api.search.params');
     if(config('toplink.pastdays')) {
       $pastdays = Carbon::today()->subday(config('toplink.pastdays'));Log::info($pastdays);
       $pastdays->hour =3;
       $pastdays->minute =30;
       $params['start_time'] = $pastdays->toIso8601ZuluString() ;// dd($params);
       //cheat
       //$params['start_time'] = str_replace(':00Z',':000Z',$params['start_time']);
//       $params['end_time'] = '2022-08-19T01:30:00.000Z';
       //Log::info($params);
      }

     //Get all friend( following)
     try
     {
       $following = $this->getFollowing($username);
       $friends = [];
       foreach($following as $k=>$follow) {
         //$params['query'] = sprintf($params['query'],$follow->username);
         //get tweet on per following user
         $friends[] = sprintf('from:%s', $follow->username);
       }
       $params['query'] = sprintf($params['query'], implode(' OR ', $friends));
       //Log::info($params);
       //dd($params);

       $tweetsInfo = $this->getTweets($params);
       if(count($tweetsInfo['tweet_ids'])>0) {
         //Check exist of tweets
         $existTweets = $this->existFeed ($tweetsInfo['tweet_ids']);//dump($tweetsInfo);
         if($existTweets) {
           //remove exist of tweets out of array
           foreach ($existTweets as $key=>$existTweet) {
             unset($tweetsInfo['tweet_datas'][$existTweet['reference_id']]);
             unset($tweetsInfo['tweet_links'][$existTweet['reference_id']]);
           }
         }

         //save tweet to database
         $this->saveFeed($tweetsInfo['tweet_datas'] );
         //calculate and save sharelink/ domain to database
         $this->counting($tweetsInfo['tweet_links']);
       }
       Log::info($tweetsInfo);
       //}
    }
    catch (ClientException $e) {
      $response = $e->getResponse();
      $responseBodyAsString = $response->getBody()->getContents();
      $content = json_decode($responseBodyAsString);
      Log::error($content->errors);
      return abort(400,$content->detail);
    }

   }

   protected function existFeed($tweetsIds)
   {
     $existFeeds =  Feed::wherein('reference_id',$tweetsIds)->get();
     if($existFeeds) {
       //check exist id of twitter
       return $existFeeds->toArray();
     }
     return null;
   }

   protected function saveFeed($tweetsArr)
   {
     if(count($tweetsArr)>0) {
       Feed::insert($tweetsArr);
     }
   }

   protected function counting($tweetsLinks)
   {
     //Note: call database too much. Need to improve coding
     foreach($tweetsLinks as $key=>$urls) {
       foreach($urls as $url) {
          $link = SharedLink::where('link_url',$url)->first();
          if($link != null) {
            $counting = $link->counting + 1;
            SharedLink::where('link_url',$url)->update(['counting'=>$counting]);
          } else {
            SharedLink::insert(['counting'=>1,'link_url'=>$url]);
          }
          $urlExtract = parse_url($url);
          $domain = $urlExtract['host'];
          $dm = SharedDomain::where('domain_url',$domain)->first();

          if($dm != null) {
            $counting = $dm->counting + 1;
            SharedDomain::where('domain_url',$domain)->update(['counting'=>$counting]);
          } else {
            SharedDomain::insert(['counting'=>1,'domain_url'=>$domain]);
          }
       }
     }
   }
}
