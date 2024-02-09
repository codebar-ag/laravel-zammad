<?php

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;

it('can download an attachment', function () {
    $content = (new Zammad())->attachment()->download(
        ticketId: 32,
        commentId: 111,
        attachmentId: 42,
    );

    $this->assertSame(46034, strlen($content));
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('attachments');
