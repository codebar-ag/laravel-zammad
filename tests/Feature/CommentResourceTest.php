<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\Attachment;
use CodebarAg\Zammad\DTO\Comment;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

it('does show by ticket', function () {
    $id = 32;

    $comments = (new Zammad)->comment()->showByTicket($id);

    $this->assertInstanceOf(Collection::class, $comments);

    $comments->each(function (Comment $comment) use ($id) {
        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertSame($id, $comment->ticket_id);
    });

    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('comments');

it('does show comment', function () {
    $id = 66;

    $comment = (new Zammad)->comment()->show($id);

    $this->assertInstanceOf(Comment::class, $comment);
    $this->assertSame($id, $comment->id);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('comments');

it('does create comment', function () {
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

    $comment = (new Zammad)->comment()->create($data);

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
    Event::assertDispatched(ZammadResponseLog::class, 1);
    (new Zammad)->comment()->delete($comment->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('comments');

it('does parse body from comment', function () {
    $comment = (new Zammad)->comment()->show(342);

    $this->assertStringContainsString(
        'Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans.',
        $comment->body,
    );
    $this->assertStringContainsString(
        'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte.',
        $comment->body,
    );
    $this->assertStringContainsString(
        'Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans.',
        $comment->body_filtered,
    );
})->group('comments');

it('has a from name helper', function () {
    $id = 66;

    $comment = (new Zammad)->comment()->show($id);

    $this->assertSame(
        Str::before(Str::between($comment->from, '"', '"'), '<'),
        $comment->fromName(),
    );
})->group('comments', 'helpers');

it('has a from email helper', function () {
    $id = 66;

    $comment = (new Zammad)->comment()->show($id);

    $this->assertSame(
        Str::between($comment->from, '<', '>'),
        $comment->fromEmail(),
    );
})->group('comments', 'helpers');
