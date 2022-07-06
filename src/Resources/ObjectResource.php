<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\ObjectAttribute;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ObjectResource
{
    protected $httpRetryMaxium;

    protected $httpRetryDelay;

    public function __construct()
    {
        $this->httpRetryMaxium = config('zammad.http_retry_maximum');
        $this->httpRetryDelay = config('zammad.http_retry_delay');
    }

    public function list(): Collection
    {
        $url = sprintf(
            '%s/api/v1/object_manager_attributes',
            config('zammad.url'),
        );

        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->get($url);

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

        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->get($url);

        event(new ZammadResponseLog($response));

        $object = $response->throw()->json();

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
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
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

        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->post($url);

        event(new ZammadResponseLog($response));

        $response->throw();
    }
}
