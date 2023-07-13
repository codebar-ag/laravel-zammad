<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AllTicketsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public bool $expand = false
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tickets';
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }
}
