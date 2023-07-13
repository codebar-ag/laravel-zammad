<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateTicketRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tickets';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
