<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\ObjectAttribute;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ObjectResource
{
    public function list(): Collection
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes',
            config('zammad.url'),
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $objects = $response->throw()->json();

        return collect($objects);
    }

    public function show(int $id): ?ObjectAttribute
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $object = $response->throw()->json();

        ray($object)->blue();
        return ObjectAttribute::fromJson($object);
    }

    public function update(int $id, array $data): ObjectAttribute
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))
            ->retry(2, 1000)
            ->put($url, $data);

        $object = $response->throw()->json();

        return ObjectAttribute::fromJson($object);
    }

    public function executeMigrations(): void
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes_execute_migrations/',
            config('zammad.url'),
        );

        $response = Http::withToken(config('zammad.token'))->post($url);

        event(new ZammadResponseLog($response));

        $response->throw();
    }
}
