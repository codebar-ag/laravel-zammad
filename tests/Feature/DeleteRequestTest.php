<?php

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Requests\Tickets\DestroyTicketRequest;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;
use Saloon\Config;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    Config::preventStrayRequests();

    config([
        'zammad.http_retry_maximum' => 3,
        'zammad.http_retry_delay' => 0,
    ]);
});

afterEach(function () {
    MockClient::destroyGlobal();
    Config::clearGlobalMiddleware();
});

it('ignores the reference error on delete when configured', function () {
    config(['zammad.object_reference_error_ignore' => true]);

    $mockClient = MockClient::global([
        DestroyTicketRequest::class => MockResponse::make(
            ['error' => 'Can&#39;t delete, object has references.'],
            422,
        ),
    ]);

    (new Zammad)->ticket()->delete(1);

    $mockClient->assertSentCount(3);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets', 'delete');

it('throws the reference error on delete when not configured to ignore it', function () {
    config(['zammad.object_reference_error_ignore' => false]);

    MockClient::global([
        DestroyTicketRequest::class => MockResponse::make(
            ['error' => 'Can&#39;t delete, object has references.'],
            422,
        ),
    ]);

    (new Zammad)->ticket()->delete(1);
})->throws(RequestException::class)->group('tickets', 'delete');

it('throws other errors on delete even when the reference error is ignored', function () {
    config(['zammad.object_reference_error_ignore' => true]);

    MockClient::global([
        DestroyTicketRequest::class => MockResponse::make(['error' => 'Not authorized'], 403),
    ]);

    (new Zammad)->ticket()->delete(1);
})->throws(RequestException::class)->group('tickets', 'delete');

it('deletes successfully', function () {
    $mockClient = MockClient::global([
        DestroyTicketRequest::class => MockResponse::make([], 200),
    ]);

    (new Zammad)->ticket()->delete(1);

    $mockClient->assertSentCount(1);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets', 'delete');
