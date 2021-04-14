<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TicketResource
{
    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $tickets = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return collect($tickets)->map(fn (array $ticket) => Ticket::fromJson($ticket));
    }

    public function search(string $term): Collection
    {
        $url = sprintf(
            '%s/api/v1/tickets/search?query=%s',
            config('zammad.url'),
            $term,
        );

        $tickets = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json('assets.Ticket');

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

        $ticket = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return Ticket::fromJson($ticket);
    }

    public function create(array $data): Ticket
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $ticket = Http::withToken(config('zammad.token'))
            ->post($url, $data)
            ->throw()
            ->json();

        return Ticket::fromJson($ticket);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id
        );

        Http::withToken(config('zammad.token'))
            ->delete($url)
            ->throw();
    }
}
