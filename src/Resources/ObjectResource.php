<?php

namespace CodebarAg\Zammad\Resources;

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

        $objects = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return collect($objects);
    }

    public function show(int $id): ?array
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes/%s',
            config('zammad.url'),
            $id,
        );

        return Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();
    }

    public function executeMigrations(): void
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes_execute_migrations/',
            config('zammad.url'),
        );

        Http::withToken(config('zammad.token'))
            ->post($url)
            ->throw();
    }
}
