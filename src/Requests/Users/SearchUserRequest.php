<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $term
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users/search?limit=1&query='.$this->term;
    }
}