<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use CodebarAg\Zammad\DTO\Ticket;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTicketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id,
        public bool $expand = false
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tickets/'.$this->id;
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }

    public function createDtoFromResponse(Response $response): Ticket
    {
        return Ticket::fromJson($response->json(), $this->expand);
    }
}
