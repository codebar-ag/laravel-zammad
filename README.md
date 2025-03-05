<img src="https://banners.beyondco.de/Laravel%20Zammad.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-zammad&pattern=circuitBoard&style=style_2&description=An+opinionated+way+to+integrate+Zammad+with+Laravel&md=1&showWatermark=0&fontSize=150px&images=ticket&widths=500&heights=500">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![GitHub-Tests](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml)
[![GitHub Code Style](https://github.com/codebar-ag/laravel-zammad/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/fix-php-code-style-issues.yml)
[![PHPStan](https://github.com/codebar-ag/laravel-zammad/actions/workflows/phpstan.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/phpstan.yml)
[![Dependency Review](https://github.com/codebar-ag/laravel-zammad/actions/workflows/dependency-review.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/dependency-review.yml)

This package was developed to give you a quick start to communicate with the
Zammad REST API. It is used to query the most common endpoints.

⚠️ This package is not designed as a replacement of the official
[Zammad REST API](https://docs.zammad.org/en/latest/api/intro.html).
See the documentation if you need further functionality. ⚠️

## 💡 What is Zammad?

Zammad is a web-based open source helpdesk/customer support system with many
features to manage customer communication.

## 🛠 Requirements

| Package 	 | PHP 	       | Laravel 	      | Zammad 	 |
|-----------|-------------|----------------|----------|
| v12.0     | ^8.2 - ^8.4 | Laravel 12.0   | ✅        |
| v11.0     | ^8.2 - ^8.3 | Laravel 11.0   | ✅        |
| v3.0      | 8.2         | Laravel 10.0   | ✅        |
| v2.0 	    | 8.1 	       | Laravel 9.0 	  | ✅	       |
| v1.0 	    | 8.0 	       | Laravel 8.12 	 | ✅        |

## ⚙️ Installation

You can install the package via composer:

```bash
composer require codebar-ag/laravel-zammad
```

Add the following environment variables to your `.env` file:

```bash
ZAMMAD_URL=https://domain.zammad.com
ZAMMAD_TOKEN=token
```

### 🔑 Where can I find the token?

Go to your profile page in your Zammad application. In the tab **Token Access** you
can create your token. Be sure to activate all rights you need.

👉 Make sure to activate **HTTP Token Authentication** in your system settings.

### 📝 How to add dynamic ticket attributes?

- Publish your configuration file (see chapter `🔧 Configuration file`).
- Add attributes to the *ticket* key:

```php 
'ticket' => [
    'note' => 'string',
    'additional_id' => 'integer',
],
```

## 🏗 Usage

### 👶 User Resource

```php
use CodebarAg\Zammad\Facades\Zammad;
```

```php
/**
 * Get the current authenticated user.
 */
 
$user = Zammad::user()->me();
```

```php
/**
 * Show a list of users.
 */
 
$users = Zammad::user()->list();
```

```php
/**
 * Search a single user.
 */
 
$term = 'email:sebastian.fix@codebar.ch';
 
$user = Zammad::user()->search($term);
```

```php
/**
 * Show a user by id.
 */
 
$user = Zammad::user()->show(20);
```

```php
/**
 * Create a new user.
 */
 
$data = [
    'firstname' => 'Max',
    'lastname' => 'Mustermann',
        'email' => 'max.mustermann@codebar.ch',
];

$user = (new Zammad())->user()->create($data);
```

```php
/**
 * Update a existing user.
 */
 
$data = [
    'firstname' => 'Max',
    'lastname' => 'Mustermann',
];

$user = (new Zammad())->user()->update($id, $data);
```

```php
/**
 * Delete a user by id.
 */
 
(new Zammad())->user()->delete(20);
```

```php
/**
 * Search a user by email. If not found create a new user.
 */
 
$user = (new Zammad())->user()->searchOrCreateByEmail('max.mustermann@codebar.ch');
```

```php
/**
 * Search a user by email. If not found create a new user with custom $data
 */
 
$data = [
    'firstname' => 'Max',
    'lastname' => 'Mustermann',
    'email' => 'max.mustermann@codebar.ch',
];

$user = (new Zammad())->user()->searchOrCreateByEmail('max.mustermann@codebar.ch', $data);
```

### 🎫 Ticket Resource

```php
use CodebarAg\Zammad\Facades\Zammad;
```

```php
/**
 * Show a list of tickets.
 */
 
$tickets = Zammad::ticket()->list();
```

```php
/**
 * Search tickets which include following term.
 */
 
$term = 'Max Mustermann';
 
$tickets = Zammad::ticket()->search($term);
```

```php
/**
 * Show a ticket by id (empty comments).
 */
 
$ticket = Zammad::ticket()->show(20);
```

```php
/**
 * Show a ticket by id with comments.
 */
 
$ticket = Zammad::ticket()->showWithComments(20);
```

```php
/**
 * Create a new ticket.
 */
 
$data = [
    'title' => 'The application is not working',
    'group' => 'Inbox',
    'customer_id' => 20,
    // 'customer' => 'bob@domain.test', // or use the customer e-mail address
    'article' => [
        'body' => 'It just crashes if I visit the page',
        'attachments' => [
            [
                'filename' => 'log.txt',
                'data' => 'V2FzdGUgbm8gbW9yZSB0aW1lIGFyZ3Vpbmcgd2hhdCBhIGdvb2QgbWFuIHNob3VsZCBiZSwgYmUgb25l',
                'mime-type' => 'text/plain'
            ],
        ],
    ],
];

$ticket = (new Zammad())->ticket()->create($data);
```

```php
/**
 * Delete a ticket by id.
 */
 
(new Zammad())->user()->delete(20);
```

### 💬 Comment Resource

```php
use CodebarAg\Zammad\Facades\Zammad;
```

```php
/**
 * Show comments by ticket id
 */
 
$comments = Zammad::comment()->showByTicket(20);
```

```php
/**
 * Show a comment by id.
 */
 
$comment = Zammad::comment()->show(20);
```

```php
/**
 * Create a new comment.
 */
 
$data = [
    'ticket_id' => 42,
    'subject' => 'Login still not working',
    'body' => 'Somehow the login is not working<br>Could you check that?',
    'content_type' => 'text/html',
    'attachments' => [
        [
            'filename' => 'log.txt',
            'data' => 'WW91IGFyZSBhIPCfjoEgZm9yIHRoZSDwn4yN',
            'mime-type' => 'text/plain',
        ],
    ],
];

$comment = (new Zammad())->comment()->create($data);
```

```php
/**
 * Delete a comment by id.
 */
 
(new Zammad())->comment()->delete(20);
```

### 🏠 Object Resource

```php
use CodebarAg\Zammad\Facades\Zammad;
```

```php
/**
 * Show a list of objects.
 */
 
$objects = Zammad::object()->list();
```

```php
/**
 * Create a object
 */
 
 $data = [
    'title' => 'sample_boolean',
    'object' => 'Ticket',
    'display' => 'Sample Boolean',
    'active' => true,
    'position' => 1500,
    'data_type' => 'select',
    'data_option' => [
        'options' => [
            'key-one' => 'First Key',
            'key-two' => 'Second Key',
            'key-three' => 'Third Key',
        ],
        'default' => 'key-one'
    ],
];

$object = Zammad::object()->create($data);
```

```php
/**
 * Update a object
 */
 
$object = Zammad::object()->update($id, $data);
```

```php
/**
 * Show a object by id.
 */
 
$object = Zammad::object()->show(20);
```

```php
/**
 * Execute database migrations
 */
 
(new Zammad())->object()->executeMigrations();
```

### 🧷 Attachment Resource

```php
use CodebarAg\Zammad\Facades\Zammad;
```

```php
/**
 * Download attachment.
 */
$content = Zammad::attachment()->download(
    ticketId: 32,
    commentId: 111,
    attachmentId: 42,
);
```

## Expanding response payloads

You can use the `expand()` method to expand the response with additional data.

See documentation on this in
the [Zammad API Docs](https://docs.zammad.org/en/latest/api/intro.html?highlight=expand#response-payloads-expand).

```php
$ticket = Zammad::ticket()->expand()->show(20);
$user = Zammad::user()->expand()->show(20);
$me = Zammad::user()->expand()->me();
```

## Limit search response payloads

You can use the `limit(int $limit = 1)` method to expand the response with additional data.

See documentation on this in the [Zammad API Docs](https://docs.zammad.org/en/latest/api/user.html#search).

```php
$ticket = Zammad::ticket()->limit(1)->search();
$user = Zammad::user()->limit(1)->search();
```

## Paginate list response payloads

You can use the `perPage(int $perPage)` and `page(int $page)` methods to set the page and per page values for the
response
Alternatively you can use the `paginate(int $page, int $perPage):` method to set both at once.

See documentation on this in the [Zammad API Docs](https://docs.zammad.org/en/latest/api/intro.html#pagination).

```php
$ticket = Zammad::ticket()->perPage(1)->page(1)->list();
$user = Zammad::user()->perPage(1)->page(1)->list();

$ticket = Zammad::ticket()->paginate(1, 1)->list();
$user = Zammad::user()->paginate(1, 1)->list();
```

## 🏋️ DTO showcase

```php
CodebarAg\Zammad\DTO\User {
  +id: 20                       // int
  +first_name: "Max"            // string
  +last_name: "Mustermann"       // string
  +login: "max.mustermann@codebar.ch"     // string
  +email: "max.mustermann@codebar.ch"     // string
  +last_login_at: Carbon\Carbon // Carbon
  +updated_at: Carbon\Carbon    // Carbon
  +created_at: Carbon\Carbon    // Carbon
```

```php
CodebarAg\Zammad\DTO\Ticket {
  +id: 32                                  // int
  +number: 69032                           // int
  +customer_id: 20                         // int
  +group_id: 3                             // int
  +state_id: 1                             // int
  +subject: "Login is not working"         // string
  +comments_count: 3                       // int
  +updated_at: Carbon\Carbon               // Carbon
  +created_at: Carbon\Carbon               // Carbon
  +comments: Illuminate\Support\Collection // Collection|Comment[]
}
```

```php
CodebarAg\Zammad\DTO\Comment {
  +id: 66                                       // int
  +type_id: 10                                  // int
  +ticket_id: 32                                // int
  +sender_id: 2                                 // int
  +sender: "Customer"                           // string
  +subject: "App Subject"                       // string
  +body: "We have fixed your issue! Have a great day<br><span class=\"js-signatureMarker\"></span><blockquote type=\"cite\"><div>It is not working</div></blockquote>"
  +body_without_blockquote: "We have fixed your issue! Have a great day<br>"
  +body_only_blockquote: "<blockquote type=\"cite\"><div>It is not working</div></blockquote>"
  +content_type: "text/plain"                   // string
  +from: "Max Mustermann"                        // string
  +to: null                                     // ?string
  +internal: false                              // boolean
  +created_by_id: 20                            // int
  +updated_by_id: 20                            // int
  +origin_by_id: 4                              // ?int
  +attachments: Illuminate\Support\Collection   // Collection|Attachment[]
  +updated_at: Carbon\Carbon                    // Carbon
  +created_at: Carbon\Carbon                    // Carbon
}
```

```php 
CodebarAg\Zammad\DTO\Attachment {
  +id: 313              // int
  +size: 30             // int
  +name: "log.txt"      // string
  +type: "text/plain"   // string
}
```

```php 
CodebarAg\Zammad\DTO\ObjectAttribute {
  +id: 313                      // int
  +name: "sample_object"        // string
  +object_lookup_id: 2          // int
  +display: "Sample Object"     // string
  +data_type: "select"          // string
  +position: 1500               // int
  +data_option: []              // array
  +data_option_new: []          // ?array
}
```

## 🔧 Configuration file

You can publish the config file with:

```bash
php artisan vendor:publish --tag="zammad-config"
```

This is the contents of the published config file:

```php
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
    
    /*
    |--------------------------------------------------------------------------
    | Ticket States
    |--------------------------------------------------------------------------
    | 
    | The ticket states are used to determine if a ticket is open, closed,
    | active or inactive. You can use this information to filter tickets
    | by their state. The following states are supported by default.
    | https://docs.zammad.org/en/latest/api/ticket/states.html
    |
    */

    'ticket_states' => [
        'open' => [1, 2, 3, 7],
        'closed' => [4],
        'active' => [1, 2, 3, 4, 7],
        'inactive' => [5, 6],
    ],

];
```

## 🚧 Testing

Copy your own phpunit.xml-file.

```bash
cp phpunit.xml.dist phpunit.xml
```

Modify environment variables in the phpunit.xml-file:

```xml

<env name="ZAMMAD_URL" value="https://domain.zammad.com"/>
<env name="ZAMMAD_TOKEN" value="token"/>
```

Run the tests:

```bash
./vendor/bin/pest
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## ✏️ Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

```bash
composer test
```

### Code Style

```bash
./vendor/bin/pint
```

## 🧑‍💻 Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## 🙏 Credits

- [Sebastian Fix](https://github.com/StanBarrows)
- [Ruslan Steiger](https://github.com/ruslansteiger)
- [All Contributors](../../contributors)
- [Skeleton Repository from Spatie](https://github.com/spatie/package-skeleton-laravel)
- [Laravel Package Training from Spatie](https://spatie.be/videos/laravel-package-training)

## 🎭 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
