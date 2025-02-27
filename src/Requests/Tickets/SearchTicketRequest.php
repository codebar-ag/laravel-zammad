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
        public ?int $perPage = null,
        public ?int $page = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tickets/search';
    }

    protected function defaultQuery(): array
    {
        $query = [
            'query' => $this->term,
        ];

        if ($this->limit) {
            $query['limit'] = $this->limit;
        }

        if ($this->perPage) {
            $query['per_page'] = $this->perPage;
        }

        if ($this->page) {
            $query['page'] = $this->page;
        }

        return $query;
    }
}
