<?php

use CodebarAg\Zammad\Tests\TestCase;
use Illuminate\Support\Facades\Event;

uses(TestCase::class)->in(__DIR__);

uses()->beforeEach(function () {
    Event::fake();
})->in(__DIR__);
