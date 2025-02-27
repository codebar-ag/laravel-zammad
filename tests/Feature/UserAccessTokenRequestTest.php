<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertSame;

it('lists user tokens', function () {
    $tokens = (new Zammad)->userAccesstoken()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('creates a user token', function () {
    $data = [
        'name' => Str::orderedUuid()->toString(),
        'permission' => ['admin'],
        'expires_at' => now()->addDay()->format('Y-m-d'),
    ];
    $token = (new Zammad)->userAccesstoken()->create($data);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('deletes a user token', function () {
    $data = [
        'name' => Str::orderedUuid()->toString(),
        'permission' => ['admin'],
        'expires_at' => now()->addDay()->format('Y-m-d'),
    ];
    (new Zammad)->userAccesstoken()->create($data);
    Event::assertDispatched(ZammadResponseLog::class, 1);

    $tokensBefore = (new Zammad)->userAccesstoken()->list();
    Event::assertDispatched(ZammadResponseLog::class, 2);

    $tokensCountBefore = count($tokensBefore['tokens']);

    foreach ($tokensBefore['tokens'] as $token) {
        if ($token['name'] == $data['name']) {
            (new Zammad)->userAccesstoken()->delete($token['id']);
        }
    }
    Event::assertDispatched(ZammadResponseLog::class, 3);

    $tokensAfter = (new Zammad)->userAccesstoken()->list();

    $tokensCountAfter = count($tokensAfter['tokens']);

    foreach ($tokensAfter['tokens'] as $token) {
        if ($token['name'] == $data['name']) {
            $this->fail('Token was not deleted');
        }
    }

    assertSame($tokensCountBefore - 1, $tokensCountAfter);

    Event::assertDispatched(ZammadResponseLog::class, 4);
})->group('users');
