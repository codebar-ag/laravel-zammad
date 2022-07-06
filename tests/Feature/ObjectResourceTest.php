<?php

namespace CodebarAg\Zammad\Tests\Feature;

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
    public function it_does_execute_database_migrations()
    {
        (new Zammad())->object()->executeMigrations();

        $this->assertTrue(true);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }
}
