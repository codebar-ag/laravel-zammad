<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;

class TicketResourceTest extends TestCase
{
    /** @test */
    public function it_does_fetch_a_list_of_tickets()
    {
        $tickets = (new Zammad())->ticket()->list();

        $this->assertInstanceOf(Collection::class, $tickets);
        $tickets->each(function (Ticket $ticket) {
            $this->assertInstanceOf(Ticket::class, $ticket);
        });
    }

    /** @test */
    public function it_does_search_tickets()
    {
        $term = 'fix';

        $tickets = (new Zammad())->ticket()->search($term);

        $this->assertInstanceOf(Collection::class, $tickets);
        $tickets->each(function (Ticket $ticket) {
            $this->assertInstanceOf(Ticket::class, $ticket);
        });
    }

    /** @test */
    public function it_does_search_tickets_with_empty_result()
    {
        $term = '::this-should-return-null::';

        $tickets = (new Zammad())->ticket()->search($term);

        $this->assertInstanceOf(Collection::class, $tickets);
        $this->assertCount(0, $tickets);
    }

    /** @test */
    public function it_does_show_ticket()
    {
        $id = 32;

        $ticket = (new Zammad())->ticket()->show($id);

        $this->assertInstanceOf(Ticket::class, $ticket);
        $this->assertSame($id, $ticket->id);
    }

    /** @test */
    public function it_does_create_and_delete_ticket()
    {
        $data = [
            'title' => '::title::',
            'group' => 'Inbox',
            'customer' => 'ruslan.steiger@codebar.ch',
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
        $this->assertSame(20, $ticket->user_id);

        (new Zammad())->ticket()->delete($ticket->id);
    }
}
