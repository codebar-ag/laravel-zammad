<?php

namespace CodebarAg\Zammad\Requests\AccessTokens;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DestroyAccessTokenRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        public int $id,
        public bool $expand = false
    ) {}

    public function resolveEndpoint(): string
    {
        return '/user_access_token/'.$this->id;
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }
}
