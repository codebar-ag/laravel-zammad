<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

it('lists tickets', function () {
    $tickets = (new Zammad())->ticket()->list();

    $this->assertInstanceOf(Collection::class, $tickets);
    $tickets->each(function (Ticket $ticket) {
        $this->assertInstanceOf(Ticket::class, $ticket);
    });

    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets');

it('searches tickets', function () {
    $term = 'fix';

    $tickets = (new Zammad())->ticket()->search($term);

    $this->assertInstanceOf(Collection::class, $tickets);
    $tickets->each(function (Ticket $ticket) {
        $this->assertInstanceOf(Ticket::class, $ticket);
    });
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets');

it('searches tickets with empty result', function () {
    $term = '::this-should-return-null::';

    $tickets = (new Zammad())->ticket()->search($term);

    $this->assertInstanceOf(Collection::class, $tickets);
    $this->assertCount(0, $tickets);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets');

it('shows a ticket', function () {
    $id = 32;

    $ticket = (new Zammad())->ticket()->show($id);

    $this->assertInstanceOf(Ticket::class, $ticket);
    $this->assertSame($id, $ticket->id);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('tickets');

it('shows a ticket with comments', function () {
    $id = 32;

    $ticket = (new Zammad())->ticket()->showWithComments($id);

    $this->assertInstanceOf(Ticket::class, $ticket);
    $this->assertSame($id, $ticket->id);
    $this->assertInstanceOf(Collection::class, $ticket->comments);
    $this->assertTrue($ticket->comments->count() > 0);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('tickets');

it('create and delete a ticket', function () {
    $data = [
        'title' => '::title::',
        'group' => 'Inbox',
        'customer' => 'sebastian.fix@codebar.ch',
        'article' => [
            'body' => '::body::',
            'type' => 'note',
            'internal' => false,
        ],
        'house' => 20,
    ];

    $ticket = (new Zammad())->ticket()->create($data);

    $this->assertInstanceOf(Ticket::class, $ticket);
    $this->assertSame('::title::', $ticket->subject);

    //4 customer_id => Sebastian Fix
    $this->assertSame(4, $ticket->customer_id);
    Event::assertDispatched(ZammadResponseLog::class, 1);

    (new Zammad())->ticket()->delete($ticket->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('tickets');

it('shows a ticket expanded', function () {
    $id = 32;

    $ticket = (new Zammad())->ticket()->show($id);
    $ticketExpand = (new Zammad())->ticket()->expand()->show($id);

    $this->assertInstanceOf(Ticket::class, $ticket);
    $this->assertInstanceOf(Ticket::class, $ticketExpand);
    Event::assertDispatched(ZammadResponseLog::class, 2);

    $this->assertSame($ticket->id, $ticketExpand->id);
    $this->assertNull($ticket->expanded);
    $this->assertNotNull($ticketExpand->expanded);
})->group('tickets', 'expand');

it('paginates ticket list', function () {
    $users = (new Zammad())->ticket()->paginate(1, 2)->list();
    $usersTwo = (new Zammad())->ticket()->paginate(2, 2)->list();

    $this->assertNotSame($users, $usersTwo);

})->group('tickets', 'paginate');

it('paginates ticket list with page and perPage methods', function () {
    $tickets = (new Zammad())->ticket()->page(1)->perPage(2)->list();
    $ticketsTwo = (new Zammad())->ticket()->page(2)->perPage(2)->list();

    $this->assertNotSame($tickets, $ticketsTwo);


})->group('tickets', 'paginate');
