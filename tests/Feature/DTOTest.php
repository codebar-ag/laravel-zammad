<?php

namespace CodebarAg\Zammad\Tests\Feature;

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
