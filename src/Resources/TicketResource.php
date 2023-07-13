<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Facades\Zammad;
use CodebarAg\Zammad\Requests\Tickets\AllTicketsRequest;
use CodebarAg\Zammad\Requests\Tickets\CreateTicketRequest;
use CodebarAg\Zammad\Requests\Tickets\DestroyTicketRequest;
use CodebarAg\Zammad\Requests\Tickets\GetTicketRequest;
use CodebarAg\Zammad\Requests\Tickets\SearchTicketRequest;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\RequestException;

class TicketResource extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function list(): Collection
    {
        $response = self::request(new AllTicketsRequest);

        $tickets = $response->json();

        return collect($tickets)->map(fn (array $ticket) => Ticket::fromJson($ticket));
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function search(string $term): Collection
    {
        $response = self::request(new SearchTicketRequest($term));

        $tickets = $response->json('assets.Ticket');

        return collect($tickets)
            ->map(fn (array $ticket) => Ticket::fromJson($ticket))
            ->values();
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function show(int $id): ?Ticket
    {
        $response = self::request(new GetTicketRequest($id));

        $ticket = $response->json();

        return Ticket::fromJson($ticket);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function showWithComments(int $id): ?Ticket
    {
        $response = self::request(new GetTicketRequest($id));

        $ticket = Ticket::fromJson($response->json());

        $ticket->comments = Zammad::comment()->showByTicket($id);

        return $ticket;
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function create(array $data): Ticket
    {
        $response = self::request(new CreateTicketRequest($data));

        $ticket = $response->json();

        return Ticket::fromJson($ticket);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     */
    public function delete(int $id): void
    {
        self::deleteRequest(new DestroyTicketRequest($id));
    }
}
