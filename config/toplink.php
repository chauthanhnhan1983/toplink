<?php

return [
  'pastdays' => 7,
  'twitter' => [
      'credentials' => [
          //these are preset values that you can obtain from developer portal:
          'bearer_token' => 'xxxxx', // OAuth 2.0 Bearer Token requests
          'consumer_key' => 'xxxxx', // identifies your app, always needed
          'consumer_secret' => 'xxxx', // app secret, always needed

          //this is a value created duting an OAuth 2.0 with PKCE authentication flow:
          'auth_token' => 'xxxxxx', // OAuth 2.0 auth token

          //these are values created during an OAuth 1.0a authentication flow:
          'token_identifier' => 'xxxx', // OAuth 1.0a User Context requests
          'token_secret' => 'xxxx', // OAuth 1.0a User Context requests
      ],
      'api' =>[
          'search' =>[
            'params' =>[
              'query' => '(%s) has:links',
              'tweet.fields' => 'attachments,author_id,created_at',
              'expansions'   => 'attachments.media_keys',
              'user.fields' => 'url',
            ],
          ],
        'following' =>[
          'params' =>[
            'max_results' => 20,
            'user.fields' => 'profile_image_url'
          ],
        ],
      ],
  ],
];
