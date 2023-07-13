<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\ObjectAttribute;
use CodebarAg\Zammad\Requests\ObjectAttribute\AllObjectAttributesRequest;
use CodebarAg\Zammad\Requests\ObjectAttribute\CreateObjectAttributeRequest;
use CodebarAg\Zammad\Requests\ObjectAttribute\DestroyObjectAttributeRequest;
use CodebarAg\Zammad\Requests\ObjectAttribute\ExecuteMigrationsObjectAttributeRequest;
use CodebarAg\Zammad\Requests\ObjectAttribute\GetObjectAttributeRequest;
use CodebarAg\Zammad\Requests\ObjectAttribute\UpdateObjectAttributeRequest;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\RequestException;

class ObjectAttributeResource extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function list(): Collection
    {
        $response = self::request(new AllObjectAttributesRequest);

        $objects = $response->json();

        return collect($objects)->map(fn (array $object) => ObjectAttribute::fromJson($object));
    }

    public function show(int $id): ?ObjectAttribute
    {
        $response = self::request(new GetObjectAttributeRequest($id));

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function create(array $data): ObjectAttribute
    {
        $response = self::request(new CreateObjectAttributeRequest($data));

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function update(int $id, array $data): ObjectAttribute
    {
        $response = self::request(new UpdateObjectAttributeRequest($id, $data));

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function delete(int $id): void
    {
        self::deleteRequest(new DestroyObjectAttributeRequest($id));
    }

    public function executeMigrations(): void
    {
        self::request(new ExecuteMigrationsObjectAttributeRequest);
    }
}
