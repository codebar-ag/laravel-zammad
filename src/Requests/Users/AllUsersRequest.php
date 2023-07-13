<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AllUsersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public bool $expand = false
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }
}
