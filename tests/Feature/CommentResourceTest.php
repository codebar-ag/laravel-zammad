<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Comment;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;

class CommentResourceTest extends TestCase
{
    /** @test */
    public function it_does_show_by_ticket()
    {
        $id = 32;

        $comments = (new Zammad())->comment()->showByTicket($id);

        $this->assertInstanceOf(Collection::class, $comments);
        $comments->each(function (Comment $comment) use ($id) {
            $this->assertInstanceOf(Comment::class, $comment);
            $this->assertSame($id, $comment->ticket_id);
        });
    }

    /** @test */
    public function it_does_show_comment()
    {
        $id = 66;

        $comment = (new Zammad())->comment()->show($id);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertSame($id, $comment->id);
    }

    /** @test */
    public function it_does_create_comment()
    {
        $data = [
            'ticket_id' => 32,
            'subject' => '::subject::',
            'body' => '::body::',
            'content_type' => 'text/html',
            'type' => 'note',
            'internal' => false,
        ];

        $comment = (new Zammad())->comment()->create($data);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertSame('::subject::', $comment->subject);
        $this->assertSame('::body::', $comment->body);
        $this->assertSame(32, $comment->ticket_id);

        (new Zammad())->comment()->delete($comment->id);
    }
}
