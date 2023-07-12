<?php

namespace CodebarAg\Zammad;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class ZammadConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        if (! config('zammad.url')) {
            throw new \Exception('No url provided.', 500);
        }

        return config('zammad.url').'/api/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(config('zammad.token'));
    }
}
