<?php

use CodebarAg\Zammad\Tests\TestCase;
use Illuminate\Support\Facades\Event;

uses(TestCase::class)->in(__DIR__);

uses()->beforeEach(function () {
    Event::fake();
})->in(__DIR__);

// These tests call a real Zammad instance (ZAMMAD_URL / ZAMMAD_TOKEN) and create or delete data.
uses()->group('live')->in(
    'Feature/AttachmentResourceTest.php',
    'Feature/CommentResourceTest.php',
    'Feature/ObjectAttributeResourceTest.php',
    'Feature/TicketResourceTest.php',
    'Feature/UserAccessTokenRequestTest.php',
    'Feature/UserResourceTest.php',
);
