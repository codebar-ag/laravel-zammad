<?php

namespace CodebarAg\Zammad\Requests\Tickets;

use CodebarAg\Zammad\DTO\Ticket;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTicketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/tickets/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): Ticket
    {
        return Ticket::fromJson($response->json());
    }
}
