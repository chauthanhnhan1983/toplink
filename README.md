# Toplink

1. The app should let the user log in with Twitter.
2. Once authenticated, the app pulls just the tweet's that contain URLs from a users stream
(friends + users posts) for the past X days i.e. Assume if we need for the last 10 days or
20 days should be configurable, default has to be 7 days

## Install

Install via composer.

```bash
composer require laravel/socialite
```

```bash
composer require coderjerk/bird-elephant
```

## Authentication

You will need to generate your credentials when creating your App in Developer Portal.

Follow the Twitter developer documentation above on how to do this. Make sure to grant your app the correct permissions, and enable 3 legged OAuth if you need it.

Pass the credentials as a key value array as follows:

Edit at **config/toplink.php**
```php
$credentials = array(
    //these are values that you can obtain from developer portal:
    'consumer_key' => xxxxxx, // identifies your app, always needed
    'consumer_secret' => xxxxxx, // app secret, always needed
    'bearer_token' => xxxxxx, // OAuth 2.0 Bearer Token requests

    //this is a value created duting an OAuth 2.0 with PKCE authentication flow:
    'auth_token' => xxxxxx // OAuth 2.0 auth token

    //these are values created during an OAuth 1.0a authentication flow to act ob behalf of other users, but these can also be obtained for your app from the developer portal in order to act on behalf of your app.
    'token_identifier' => xxxxxx, // OAuth 1.0a User Context requests
    'token_secret' => xxxxxx, // OAuth 1.0a User Context requests
);


```

Edit at **.env**
```php
TWITTER_CLIENT_ID=XXX
TWITTER_CLIENT_SECRET=XXX
TWITTER_REIDRECT={could get it form route('auth.twitter_callback')}
```

Run script **database/toplink.sql** to install database



## Demonstration
### Screen Flow
    [Home] --redirect--> [Login] ----click----> [Twitter Login] ---Authention---> [Home]----call Ajax--->[calculating] ----completed--->[dashboard]
### Url
[For testing and demonstration](https://toplink.7thanh.x10.mx/)


## Reference
- [Bird Elephant Reference](https://birdelephant.com)
- [Twitter API reference index](https://developer.twitter.com/en/docs/api-reference-index)

## Notes

Limitation: 
- Not do execute yet when API's results have pagination.
- Have Not test yet in the case of get data before Aug-12th. beacuse API alway return error in this case
- Have not refactor code yet( need to install [PHPQA](https://github.com/EdgedesignCZ/phpqa)).
- Some API has not yet. Because I have no data from twitter( I already register twitter account) and ho time to research API Twitter.


