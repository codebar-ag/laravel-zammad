<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

it('lists user tokens', function () {
    $tokens = (new Zammad())->userAccesstoken()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('creates a user token', function () {
    $data = [
        'label' => Str::orderedUuid()->toString(),
        'permission' => ['admin'],
        'expires_at' => now()->addDay()->format('Y-m-d'),
    ];
    $token = (new Zammad())->userAccesstoken()->create($data);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');
