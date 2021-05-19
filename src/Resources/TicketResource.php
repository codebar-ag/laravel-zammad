<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\Ticket;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Facades\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TicketResource
{
    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $tickets = $response->throw()->json();

        return collect($tickets)->map(fn (array $ticket) => Ticket::fromJson($ticket));
    }

    public function search(string $term): Collection
    {
        $url = sprintf(
            '%s/api/v1/tickets/search?query=%s',
            config('zammad.url'),
            $term,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $tickets = $response->throw()->json('assets.Ticket');

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

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $ticket = $response->throw()->json();

        return Ticket::fromJson($ticket);
    }

    public function showWithComments(int $id): ?Ticket
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $ticket = Ticket::fromJson($response->throw()->json());

        $ticket->comments = Zammad::comment()->showByTicket($id);

        return $ticket;
    }

    public function create(array $data): Ticket
    {
        $url = sprintf('%s/api/v1/tickets', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))
            ->retry(2)
            ->post($url, $data);

        event(new ZammadResponseLog($response));

        $ticket = $response->throw()->json();

        return Ticket::fromJson($ticket);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/tickets/%s',
            config('zammad.url'),
            $id
        );

        $response = Http::withToken(config('zammad.token'))
            ->retry(2)
            ->delete($url);

        event(new ZammadResponseLog($response));

        $response->throw();
    }
}
