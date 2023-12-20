<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchTicketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $term,
        public ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tickets/search';
    }

    protected function defaultQuery(): array
    {
        return [
            'query' => $this->term,
            'limit' => $this->limit,
        ];
    }
}
