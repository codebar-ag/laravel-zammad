<?php

use CodebarAg\Zammad\DTO\ObjectAttribute;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

it('lists objects', function () {
    $objects = (new Zammad)->object()->list();
    $this->assertInstanceOf(Collection::class, $objects);
    $this->assertTrue($objects->count() > 0);
    Event::assertDispatched(ZammadResponseLog::class, 1);
})->group('objects', 'list-objects');

it('shows a object', function () {
    $objects = (new Zammad)->object()->list();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $object = $objects->last();

    $newObject = (new Zammad)->object()->show($object->id);
    $this->assertSame($object->id, $newObject->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('objects', 'show-object');

it('creates a object', function () {
    $objectAttribute = ObjectAttribute::fakeCreateToArray();
    $object = (new Zammad)->object()->create($objectAttribute);

    $this->assertInstanceOf(ObjectAttribute::class, $object);
    $this->assertSame($objectAttribute['name'], $object->name);
    $this->assertSame($objectAttribute['display'], $object->display);
    Event::assertDispatched(ZammadResponseLog::class, 1);

    (new Zammad)->object()->delete($object->id);
    (new Zammad)->object()->executeMigrations();

})->group('objects', 'create-object');

it('update a object', function () {
    $objectAttribute = ObjectAttribute::fakeCreateToArray();
    $object = (new Zammad)->object()->create($objectAttribute);
    Event::assertDispatched(ZammadResponseLog::class, 1);
    $this->assertInstanceOf(ObjectAttribute::class, $object);

    $updatedObjectAttribute = [
        'name' => $object->name,
        'object' => 'Ticket',
        'display' => 'Updated Sample Object',
        'position' => $object->position,
        'data_type' => $object->data_type,
        'data_option' => [
            'options' => [
                'key-one' => 'First Key',
                'key-two' => 'Second Key',
                'key-three' => 'Third Key',
                'key-four' => 'Fourth Key',
            ],
            'default' => 'key-two',
        ],
    ];

    expect($objectAttribute['display'])->toEqual($object->display);
    expect($updatedObjectAttribute['display'])->not()->toEqual($object->display);

    $object = (new Zammad)->object()->update($object->id, $updatedObjectAttribute);
    Event::assertDispatched(ZammadResponseLog::class, 2);
    expect($updatedObjectAttribute['display'])->toEqual($object->display);
    expect($objectAttribute['display'])->not()->toEqual($object->display);

    (new Zammad)->object()->delete($object->id);
    (new Zammad)->object()->executeMigrations();

})->group('objects', 'update-object');

it('deletes a object', function () {
    $objectAttribute = ObjectAttribute::fakeCreateToArray();
    $object = (new Zammad)->object()->create($objectAttribute);
    Event::assertDispatched(ZammadResponseLog::class, 1);

    (new Zammad)->object()->delete($object->id);
    Event::assertDispatched(ZammadResponseLog::class, 2);
})->group('objects');

// this test is migrating the zammad database which can take up to 30seconds.
it('execute database migrations', function () {
    (new Zammad)->object()->executeMigrations();
    Event::assertDispatched(ZammadResponseLog::class, 1);
    sleep(30);
})->group('objects');
