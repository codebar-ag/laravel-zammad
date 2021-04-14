<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;

class ObjectResourceTest extends TestCase
{
    /** @test */
    public function it_does_fetch_a_list_of_objects()
    {
        $objects = (new Zammad())->object()->list();

        $this->assertInstanceOf(Collection::class, $objects);
        $this->assertTrue($objects->count() > 0);
    }

    /** @test */
    public function it_does_show_an_object()
    {
        $id = 1;

        $object = (new Zammad())->object()->show($id);

        $this->assertSame($id, $object['id']);
    }

    /** @test */
    public function it_does_execute_database_migrations()
    {
        (new Zammad())->object()->executeMigrations();

        $this->assertTrue(true);
    }
}
