<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $term,
        public int $limit = 1
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/users/search';
    }

    protected function defaultQuery(): array
    {
        return [
            'query' => $this->term,
            'limit' => $this->limit,
        ];
    }
}
