# Changelog

All notable changes to `laravel-zammad` will be documented in this file.

### 2.0.0beta - 2022-07-06

#### Critical

**Comment DTO**

- Replaced $body_without_blockquote variable with $body_filtered
- Dropped $body_only_blockquote

#### Core

- Dropped support for PHP versions below 8.1
- Replaced PHPUnit for PEST
- Moved HTTP requests to a dedicated class `RequestClass.php`

#### Improvements

- Added dynamic retry values for failed HTTP requests that can be set via the configuration file
- You can now pass User attributes within the searchOrCreateByEmail method to update or create user
  attributes within the same request.
- Added a dynamic HTML Stripe-Out for Signature and Replied HTML via the configuration file
- Define via configuration variable if a 'Unprocessable Entity' response related to an object reference should be
  ignored. [More information](https://docs.zammad.org/en/latest/api/user.html#update).

#### Features

- Create & Update Zammad Objects
- Update Zammad User

### 1.0.0 - 2021-07-22

- Stable release.

### 0.1.2 - 2021-05-19

- Added `origin_by_id` to the comment DTO
- Added `sender` to the comment DTO

### 0.1.1 - 2021-05-18

- Added `body_without_blockquote` and `body_only_blockquote` attribute to the
  comment DTO

### 0.1.0 - 2021-05-18

- ⚠️ [Breaking Change] Changed `user_id` to `customer_id` in the ticket DTO
- Added sender_id for the comment DTO
- Optional subject for the comment DTO
- Added ticket showWithComment endpoint
- Added URL for the attachment DTO

## 0.0.1 - 2021-04-21

- Facade was not registered correct.

## 0.0.0 - 2021-04-21

- 🎉 initial release
