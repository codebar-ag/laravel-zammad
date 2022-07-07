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

    'http_retry_maximum' => env('ZAMMAD_HTTP_RETRY_MAXIMUM', 3),
    'http_retry_delay' => env('ZAMMAD_HTTP_RETRY_DELAY', 1500),

    /*
    |--------------------------------------------------------------------------
    | Object reference error on delete request
    |--------------------------------------------------------------------------
    |
    | Please note that removing data cannot be undone. Zammad will also remove references - thus potentially tickets!
    | Removing data with references in e.g. activity streams is not possible via API - this will be indicated by "error":
    | "Can't delete, object has references." (Status 422). This is not a bug.
    | Consider using Data Privacy via UI for more control instead. https://docs.zammad.org/en/latest/api/user.html#delete
    |
    */

    'object_reference_error_ignore' => env('ZAMMAD_OBJECT_REFERENCE_ERROR_IGNORE', false),
    'objet_reference_error' => env('ZAMMAD_OBJECT_REFERENCE_ERROR', 'Can&#39;t delete, object has references.'),

    /*
    |--------------------------------------------------------------------------
    | Comment Object HTML Parsing
    |--------------------------------------------------------------------------
    |
    */

    'filter_images' => true,
    'filter_tables' => true,
    'filter_signature_marker' => true,
    'filter_signature_marker_value' => '<span class="js-signatureMarker"></span>',
    'filter_data_signature' => true,
    'filter_data_signature_value' => '<div data-signature="true" data-signature-id="1">',

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
