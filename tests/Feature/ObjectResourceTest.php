<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

class ObjectResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function it_does_fetch_a_list_of_objects()
    {
        $objects = (new Zammad())->object()->list();
        $this->assertInstanceOf(Collection::class, $objects);
        $this->assertTrue($objects->count() > 0);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_show_an_object()
    {
        $id = 1;

        $object = (new Zammad())->object()->show($id);
        $this->assertSame($id, $object->id);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_update_an_object()
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
        $this->assertSame(20, $ticket->customer_id);
        Event::assertDispatched(ZammadResponseLog::class, 1);

        (new Zammad())->ticket()->delete($ticket->id);
        Event::assertDispatched(ZammadResponseLog::class, 2);
    }

    /** @test */
    public function it_does_execute_database_migrations()
    {
        (new Zammad())->object()->executeMigrations();

        $this->assertTrue(true);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }
}
