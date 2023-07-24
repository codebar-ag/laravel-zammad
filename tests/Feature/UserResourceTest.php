<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

it('show current user', function () {
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

it('searches a user', function () {
    $users = (new Zammad())->user()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $user = $users->last();

    $searchedUser = (new Zammad())->user()->search($user->email);

    $this->assertInstanceOf(User::class, $searchedUser);
    $this->assertSame($user->id, $searchedUser->id);
    $this->assertSame($user->email, $searchedUser->email);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('users');

it('searches a non existing user', function () {
    $term = 'email:does@not.exist';

    $user = (new Zammad())->user()->search($term);

    $this->assertNull($user);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('users');

it('shows a user', function () {
    $users = (new Zammad())->user()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $user = $users->last();

    $newUser = (new Zammad())->user()->show($user->id);

    $this->assertInstanceOf(User::class, $newUser);
    $this->assertSame($user->id, $newUser->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('users');

it('creates a user', function () {
    $firstname = Str::orderedUuid()->toString();
    $lastname = Str::orderedUuid()->toString();
    $email = $firstname.'@codebar.ch';

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
})->group('users');

it('updates a user', function () {
    $users = (new Zammad())->user()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $user = $users->last();

    $firstname = Str::orderedUuid()->toString();
    $lastname = Str::orderedUuid()->toString();

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
    ];

    $updatedUser = (new Zammad())->user()->update($user->id, $data);
    Event::assertDispatched(ZammadResponseLog::class, 2);

    expect($firstname)->toEqual($updatedUser->first_name);
    expect($lastname)->toEqual($updatedUser->last_name);
})->group('users');

it('searches or creates a user', function () {
    $email = Str::orderedUuid()->toString().'@codebar.ch';
    $user = (new Zammad())->user()->searchOrCreateByEmail($email);
    $this->assertSame($email, $user->email);
    Event::assertDispatched(ZammadResponseLog::class, 2);
    (new Zammad())->user()->delete($user->id);
    Event::assertDispatched(ZammadResponseLog::class, 3);
})->group('users');

it('deletes a user', function () {
    $email = Str::orderedUuid()->toString().'@codebar.ch';
    $user = (new Zammad())->user()->searchOrCreateByEmail($email);
    $this->assertSame($email, $user->email);
    Event::assertDispatched(ZammadResponseLog::class, 2);

    (new Zammad())->user()->delete($user->id);
    Event::assertDispatched(ZammadResponseLog::class, 3);
})->group('users');

it('show current user expanded', function () {
    $user = (new Zammad())->user()->me();
    $userExpand = (new Zammad())->user()->expand()->me();
    $this->assertInstanceOf(User::class, $user);
    $this->assertInstanceOf(User::class, $userExpand);
    Event::assertDispatched(ZammadResponseLog::class, 2);

    $this->assertSame($user->id, $userExpand->id);
    $this->assertNull($user->expanded);
    $this->assertNotNull($userExpand->expanded);
})->group('users', 'expand');

it('show user expanded', function () {
    $users = (new Zammad())->user()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $usr = $users->last();

    $user = (new Zammad())->user()->show($usr->id);
    $userExpand = (new Zammad())->user()->expand()->show($usr->id);
    $this->assertInstanceOf(User::class, $user);
    $this->assertInstanceOf(User::class, $userExpand);
    Event::assertDispatched(ZammadResponseLog::class, 3);

    $this->assertSame($user->id, $userExpand->id);
    $this->assertNull($user->expanded);
    $this->assertNotNull($userExpand->expanded);
})->group('users', 'expand');

it('paginates user list', function () {
    $users = (new Zammad())->user()->paginate(1, 2)->list();
    $usersTwo = (new Zammad())->user()->paginate(2, 2)->list();

    $this->assertNotSame($users, $usersTwo);

})->group('users', 'paginate');

it('paginates user list with page and perPage methods', function () {
    $users = (new Zammad())->user()->page(1)->perPage(2)->list();
    $usersTwo = (new Zammad())->user()->page(2)->perPage(2)->list();

    $this->assertNotSame($users, $usersTwo);

})->group('users', 'paginate');
