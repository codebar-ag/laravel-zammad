<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Zammad credentials
    |--------------------------------------------------------------------------
    |
    | These values are used to connect your application with Zammad.
    |
    */

    'url' => env('ZAMMAD_URL'),

    'token' => env('ZAMMAD_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Dynamic ticket fields with casts
    |--------------------------------------------------------------------------
    |
    | Define dynamic fields from the Zammad object manager here.
    | Make sure to add a valid type for proper casting.
    |
    | Supported: "string", "integer", "float", "boolean", "datetime"
    |
    */

    'ticket' => [
        // 'note' => 'string',
    ],

];
