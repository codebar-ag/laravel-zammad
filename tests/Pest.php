<?php

use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;

uses(TestCase::class)->in(__DIR__);

uses()->beforeEach(function () {
    Event::fake();
})->in(__DIR__);

uses()
    ->beforeEach(function () {
        // Delete all tickets before each test
        $tickets = (new Zammad())->ticket()->list();

        foreach ($tickets as $ticket) {
            (new Zammad())->ticket()->delete($ticket->id);
        }

        // Delete all users before each test
        $users = (new Zammad())->user()->list();

        foreach ($users as $user) {
            (new Zammad())->user()->delete($user->id);
        }

    })
    ->in(__DIR__);
