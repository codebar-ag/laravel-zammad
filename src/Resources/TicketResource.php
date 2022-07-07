<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Facades\Zammad;
use Illuminate\Support\Collection;

class TicketResource extends RequestClass
{
    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $response = self::getRequest($url);

        $tickets = $response->json();

        return collect($tickets)->map(fn (array $ticket) => Ticket::fromJson($ticket));
    }

    public function search(string $term): Collection
    {
        $url = sprintf(
            '%s/api/v1/tickets/search?query=%s',
            config('zammad.url'),
            $term,
        );

        $response = self::getRequest($url);

        $tickets = $response->json('assets.Ticket');

        return collect($tickets)
            ->map(fn (array $ticket) => Ticket::fromJson($ticket))
            ->values();
    }

    public function show(int $id): ?Ticket
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $ticket = $response->json();

        return Ticket::fromJson($ticket);
    }

    public function showWithComments(int $id): ?Ticket
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $ticket = Ticket::fromJson($response->json());

        $ticket->comments = Zammad::comment()->showByTicket($id);

        return $ticket;
    }

    public function create(array $data): Ticket
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $response = self::postRequest($url, $data);

        $ticket = $response->json();

        return Ticket::fromJson($ticket);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id,
        );

        self::deleteRequest($url);
    }
}
