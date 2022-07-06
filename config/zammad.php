<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Zammad URL
    |--------------------------------------------------------------------------
    |
    | This URL is used to properly communicate with the Zammad REST-API for
    | every request that is made. Please make sure to include the scheme
    | and the hostname in it. Otherwise we can't find the destination.
    |
    */

    'url' => env('ZAMMAD_URL'),

    /*
    |--------------------------------------------------------------------------
    | Zammad Access Token
    |--------------------------------------------------------------------------
    |
    | The access token is used to authenticate with the Zammad REST-API. You
    | should make sure to activate the "HTTP Token Authentication" in the
    | configuration. Afterwards generate a token in your settings page.
    |
    */

    'token' => env('ZAMMAD_TOKEN'),

    /*
     |--------------------------------------------------------------------------
     | HTTP Retry Values
     |--------------------------------------------------------------------------
     |
     | If you would like HTTP client to automatically retry the request if a client or server error occurs,
     | you may specify the retry values. The maximum retry value specifies the number of times the request should be attempted,
     | and the retry delay value is the number of milliseconds Laravel should wait between attempts.
     |
     */

    'http_retry_maximum' => 3,
    'http_retry_delay' => 1500,

    /*
    |--------------------------------------------------------------------------
    | Dynamic Ticket Attributes with Casts
    |--------------------------------------------------------------------------
    |
    | You should define a list of all your dynamic ticket attributes here to
    | ensure that they are correctly converted into the native types. The
    | only limitation you have is to include following supported types.
    |
    | Supported: "string", "integer", "float", "boolean", "datetime"
    |
    */

    'ticket' => [
        // 'note' => 'string',
    ],

];
