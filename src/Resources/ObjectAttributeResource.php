<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\ObjectAttribute;
use Illuminate\Support\Collection;

class ObjectAttributeResource extends RequestClass
{
    public function list(): Collection
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes',
            config('zammad.url'),
        );

        $response = self::getRequest($url);

        $objects = $response->json();

        return collect($objects)->map(fn (array $object) => ObjectAttribute::fromJson($object));
    }

    public function show(int $id): ?ObjectAttribute
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function create(array $data): ObjectAttribute
    {
        $url = sprintf('%s/api/v1/object_manager_attributes', config('zammad.url'));

        $response = self::postRequest($url, $data);

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function update(int $id, array $data): ObjectAttribute
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::putRequest($url, $data);

        $object = $response->json();

        return ObjectAttribute::fromJson($object);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        self::deleteRequest($url);
    }

    public function executeMigrations(): void
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes_execute_migrations/',
            config('zammad.url'),
        );

        self::postRequest($url);
    }
}
