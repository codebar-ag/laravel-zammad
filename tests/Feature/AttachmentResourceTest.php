<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class AttachmentResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function it_can_download_an_attachment()
    {
        $content = (new Zammad())->attachment()->download(
            ticketId: 32,
            commentId: 111,
            attachmentId: 42,
        );

        $this->assertSame(37055, Str::length($content));
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }
}
