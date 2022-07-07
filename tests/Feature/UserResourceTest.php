<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

it('current user', function () {
    $user = (new Zammad())->user()->me();
    $this->assertInstanceOf(User::class, $user);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('list users', function () {
    $users = (new Zammad())->user()->list();

    $this->assertInstanceOf(Collection::class, $users);
    $users->each(function (User $user) {
        $this->assertInstanceOf(User::class, $user);
    });

    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('search a user', function () {
    //@todo dynamic user (create before)
    $term = 'email:sebastian.fix@codebar.ch';

    $user = (new Zammad())->user()->search($term);

    $this->assertInstanceOf(User::class, $user);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('search non existing user', function () {
    $term = 'email:does@not.exist';

    $user = (new Zammad())->user()->search($term);

    $this->assertNull($user);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('show user', function () {
    //@todo dynamic user (create before)
    $id = 1;

    $user = (new Zammad())->user()->show($id);

    $this->assertInstanceOf(User::class, $user);
    $this->assertSame($id, $user->id);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('create and delete user', function () {
    $firstname = 'Max';
    $lastname = 'Mustermann';
    $email = time() . '-' . Str::orderedUuid()->toString() . '@codebar.ch';

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
    ];

    $user = (new Zammad())->user()->create($data);

    $this->assertInstanceOf(User::class, $user);
    $this->assertSame($firstname, $user->first_name);
    $this->assertSame($lastname, $user->last_name);
    $this->assertStringEndsWith($email, $user->email);
    Event::assertDispatched(ZammadResponseLog::class, 1);

    (new Zammad())->user()->delete($user->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('users');

it('update and delete user', function () {
    $email = time() . '-' . Str::orderedUuid()->toString() . '@codebar.ch';
    $user = (new Zammad())->user()->searchOrCreateByEmail($email);
    Event::assertDispatched(ZammadResponseLog::class, 2);

    $firstname = 'Jutta';
    $lastname = 'Musterfrau';

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
    ];

    $updatedUser = (new Zammad())->user()->update($user->id, $data);
    Event::assertDispatched(ZammadResponseLog::class, 3);

    expect($firstname)->toEqual($updatedUser->first_name);
    expect($lastname)->toEqual($updatedUser->last_name);

    (new Zammad())->user()->delete($updatedUser->id);
    Event::assertDispatched(ZammadResponseLog::class, 4);

})->group('users');

it('search or create user', function () {
    $email = time() . '-' . Str::orderedUuid()->toString() . '@codebar.ch';
    $user = (new Zammad())->user()->searchOrCreateByEmail($email);
    $this->assertSame($email, $user->email);
    Event::assertDispatched(ZammadResponseLog::class, 2);
    (new Zammad())->user()->delete($user->id);
    Event::assertDispatched(ZammadResponseLog::class, 3);
})->group('users');
