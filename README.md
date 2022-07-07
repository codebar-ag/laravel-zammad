<img src="https://banners.beyondco.de/Laravel%20Zammad.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-zammad&pattern=circuitBoard&style=style_2&description=An+opinionated+way+to+integrate+Zammad+with+Laravel&md=1&showWatermark=0&fontSize=150px&images=ticket&widths=500&heights=500">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![run-tests](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml)
[![PHPStan](https://github.com/codebar-ag/laravel-zammad/actions/workflows/phpstan.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/phpstan.yml)
[![Check & fix styling](https://github.com/codebar-ag/laravel-zammad/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/php-cs-fixer.yml)

This package was developed to give you a quick start to communicate with the
Zammad REST API. It is used to query the most common endpoints.

⚠️ This package is not designed as a replacement of the official
[Zammad REST API](https://docs.zammad.org/en/latest/api/intro.html).
See the documentation if you need further functionality. ⚠️

## 💡 What is Zammad?

Zammad is a web based open source helpdesk/customer support system with many
features to manage customer communication.

## 🛠 Requirements

| Version | v2.0.0 | v1.0.0  |
|---------|--------|---------|
| PHP     | `^8.1` | `^8.0`  |
| Laravel| `^9.0` | `^8.12` |
| Zammad Access| ✅      | ✅       |

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

/**
 * Get the current authenticated user.
 */
$user = Zammad::user()->me();

/**
 * Show a list of users.
 */
$users = Zammad::user()->list();

/**
 * Search a single user.
 */
$term = 'email:sebastian.fix@codebar.ch';
 
$user = Zammad::user()->search($term);

/**
 * Show a user by id.
 */
$user = Zammad::user()->show(20);

/**
 * Create a new user.
 */
$data = [
    'firstname' => 'Max',
    'lastname' => 'Mustermann',
        'email' => 'max.mustermann@codebar.ch',
];

$user = (new Zammad())->user()->create($data);

/**
 * Update a existing user.
 */
$data = [
    'firstname' => 'Max',
    'lastname' => 'Mustermann',
];

$user = (new Zammad())->user()->update($id, $data);

/**
 * Delete a user by id.
 */
(new Zammad())->user()->delete(20);

/**
 * Search a user by email. If not found create a new user.
 */
$user = (new Zammad())->user()->searchOrCreateByEmail('max.mustermann@codebar.ch');

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

/**
 * Show a list of tickets.
 */
$tickets = Zammad::ticket()->list();

/**
 * Search tickets which include following term.
 */
$term = 'Max Mustermann';
 
$tickets = Zammad::ticket()->search($term);

/**
 * Show a ticket by id (empty comments).
 */
$ticket = Zammad::ticket()->show(20);

/**
 * Show a ticket by id with comments.
 */
$ticket = Zammad::ticket()->showWithComments(20);

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

/**
 * Delete a ticket by id.
 */
(new Zammad())->user()->delete(20);
```

### 💬 Comment Resource

```php
use CodebarAg\Zammad\Facades\Zammad;

/**
 * Show comments by ticket id
 */
$comments = Zammad::comment()->showByTicket(20);

/**
 * Show a comment by id.
 */
$comment = Zammad::comment()->show(20);

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

/**
 * Delete a comment by id.
 */
(new Zammad())->comment()->delete(20);
```

### 🏠 Object Resource

```php
use CodebarAg\Zammad\Facades\Zammad;

/**
 * Show a list of objects.
 */
$objects = Zammad::object()->list();

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
    'data_options' => [
        'options' => [
            'key-one' => 'First Key',
            'key-two' => 'Second Key',
            'key-three' => 'Third Key',
        ],
        'default' => 'key-one'
    ],
];

$object = Zammad::object()->create($data);

/**
 * Update a object
 */
 
 
$object = Zammad::object()->update($id, $data);

/**
 * Show a object by id.
 */
$object = Zammad::object()->show(20);

/**
 * Execute database migrations
 */
(new Zammad())->object()->executeMigrations();
```

### 🧷 Attachment Resource

```php
use CodebarAg\Zammad\Facades\Zammad;

/**
 * Download attachment.
 */
$content = Zammad::attachment()->download(
    ticketId: 32,
    commentId: 111,
    attachmentId: 42,
);
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

    'http_retry_maximum' => env('ZAMMAD_HTTP_RETRY_MAXIMUM', 5),
    'http_retry_delay' => env('ZAMMAD_HTTP_RETRY_DELAY', 1000),

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
    'objet_reference_error' => env('ZAMMAD_OBJECT_REFERENCE_ERROR', "Can&#39;t delete, object has references."),

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
