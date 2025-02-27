<?php

use CodebarAg\Zammad\ZammadConnector;

it('will throw an error if a url is not provided', function () {
    config(['zammad.url' => '']);
    (new ZammadConnector)->resolveBaseUrl();
})->throws(\Exception::class, 'No url provided.', 500)
    ->group('connector');

it('will not throw an error if a url provided', function () {
    (new ZammadConnector)->resolveBaseUrl();
})->throwsNoExceptions()
    ->group('connector');

it('will throw an error if a token is not provided', function () {
    config(['zammad.token' => '']);
    (new ZammadConnector)->setAuth();
})->throws(\Exception::class, 'No token provided.', 500)
    ->group('connector');

it('will not throw an error if a token provided', function () {
    (new ZammadConnector)->setAuth();
})->throwsNoExceptions()
    ->group('connector');
