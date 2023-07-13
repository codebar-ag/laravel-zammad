<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchTicketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $term
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tickets/search?limit=1&query='.$this->term;
    }
}
