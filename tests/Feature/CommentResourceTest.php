<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Attachment;
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
            'body' => 'huhuhuu<br>huhuhuu<br>huhuhuu<br><br>',
            'content_type' => 'text/html',
            'attachments' => [
                [
                    'filename' => 'test.txt',
                    'data' => 'RHUgYmlzdCBlaW4g8J+OgSBmw7xyIGRpZSDwn4yN',
                    'mime-type' => 'text/plain',
                ],
            ],
        ];

        $comment = (new Zammad())->comment()->create($data);
        (new Zammad())->comment()->delete($comment->id);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertSame('::subject::', $comment->subject);
        $this->assertSame('huhuhuu<br>huhuhuu<br>huhuhuu<br><br>', $comment->body);
        $this->assertSame('text/html', $comment->content_type);
        $this->assertSame(32, $comment->ticket_id);
        $this->assertCount(1, $comment->attachments);
        tap($comment->attachments->first(), function (Attachment $attachment) {
            $this->assertSame(30, $attachment->size);
            $this->assertSame('test.txt', $attachment->name);
            $this->assertSame('text/plain', $attachment->type);
        });
    }
}
