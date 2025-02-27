<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use CodebarAg\Zammad\DTO\Ticket;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateTicketRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload,
        public bool $expand = false
    ) {}

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

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): Ticket
    {
        return Ticket::fromJson($response->json());
    }
}
