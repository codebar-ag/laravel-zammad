<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AllTicketsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $perPage = null,
        public ?int $page = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tickets';
    }

    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->perPage) {
            $query['per_page'] = $this->perPage;
        }

        if ($this->page) {
            $query['page'] = $this->page;
        }

        return $query;
    }
}
