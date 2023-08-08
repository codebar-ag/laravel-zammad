<?php

namespace CodebarAg\Zammad;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class ZammadConnector extends Connector
{
    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->setAuth(), 'Bearer');
    }

    /**
     * @throws \Exception
     */
    public function setAuth(): string
    {
        if (! config('zammad.token')) {
            throw new \Exception('No token provided.', 500);
        }

        return config('zammad.token');
    }
}
