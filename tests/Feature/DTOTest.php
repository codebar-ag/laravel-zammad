<?php

namespace CodebarAg\Zammad\Tests\Feature;

use Carbon\Carbon;
use CodebarAg\Zammad\DTO\Attachment;
use CodebarAg\Zammad\DTO\Comment;
use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Tests\TestCase;

class DTOTest extends TestCase
{
    /** @test */
    public function it_does_create_a_fake_user()
    {
        $user = User::fake();

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function it_does_create_a_fake_ticket()
    {
        $ticket = Ticket::fake();

        $this->assertInstanceOf(Ticket::class, $ticket);
    }

    /** @test */
    public function it_does_add_dynamic_attributes_to_ticket()
    {
        config()->set('zammad.ticket', [
            'note' => 'string',
            'note_id' => 'integer',
            'note_value' => 'float',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
        ]);
        $data = [
            'id' => 1,
            'number' => '1',
            'customer_id' => 1,
            'group_id' => 1,
            'state_id' => 1,
            'title' => '::title::',
            'article_count' => 0,
            'updated_at' => '2021-04-06T17:21:26.995Z',
            'created_at' => '2021-04-06T17:21:26.995Z',
            'note' => '::note::',
            'note_id' => 42,
            'note_value' => 24.2,
            'is_active' => true,
            'deleted_at' => '2021-01-21T21:01:21.995Z',
        ];

        $ticket = Ticket::fromJson($data);

        $this->assertIsString($ticket->note);
        $this->assertSame('::note::', $ticket->note);
        $this->assertIsInt($ticket->note_id);
        $this->assertSame(42, $ticket->note_id);
        $this->assertIsFloat($ticket->note_value);
        $this->assertSame(24.2, $ticket->note_value);
        $this->assertIsBool($ticket->is_active);
        $this->assertTrue($ticket->is_active);
        $this->assertInstanceOf(Carbon::class, $ticket->deleted_at);
    }

    /** @test */
    public function it_does_create_a_fake_comment()
    {
        $ticket = Comment::fake();

        $this->assertInstanceOf(Comment::class, $ticket);
    }

    /** @test */
    public function it_does_create_a_fake_attachment()
    {
        $attachment = Attachment::fake();

        $this->assertInstanceOf(Attachment::class, $attachment);
    }
}
