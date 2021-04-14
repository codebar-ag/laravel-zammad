<img src="https://banners.beyondco.de/Laravel%20Zammad.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-zammad&pattern=endlessClouds&style=style_1&description=An+opinionated+way+to+integrate+Zammad+with+Larvavel&md=1&showWatermark=0&fontSize=175px&images=ticket">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-zammad.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-zammad)
[![run-tests](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/run-tests.yml)
[![Psalm](https://github.com/codebar-ag/laravel-zammad/actions/workflows/psalm.yml/badge.svg)](https://github.com/codebar-ag/laravel-zammad/actions/workflows/psalm.yml)
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

- PHP: `^8.0`
- Laravel: `^8.12`
- Zammad Access

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

Go to your profile in your Zammad application. In the tab **Token Access** you
can create your token. Be sure to activate all rights you need.

👉 Make sure to activate **HTTP Token Authentication** in your system settings.

## 🏗 Usage (WIP)

```php
use CodebarAg\DocuWare\Facades\Zammad;

// 
```

## 🔧 Configuration file (WIP)

You can publish the config file with:
```bash
php artisan vendor:publish --provider="CodebarAg\Zammad\ZammadServiceProvider" --tag="laravel-zammad-config"
```

This is the contents of the published config file:

```php
return [
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
composer test
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## ✏️ Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## 🧑‍💻 Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## 🙏 Credits

- [Ruslan Steiger](https://github.com/SuddenlyRust)
- [All Contributors](../../contributors)
- [Skeleton Repository from Spatie](https://github.com/spatie/package-skeleton-laravel)
- [Laravel Package Training from Spatie](https://spatie.be/videos/laravel-package-training)

## 🎭 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
