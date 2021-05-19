<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\Comment;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CommentResource
{
    public function showByTicket(int $id): Collection
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/by_ticket/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $comment = $response->throw()->json();

        return collect($comment)->map(fn (array $comment) => Comment::fromJson($comment));
    }

    public function show(int $id): ?Comment
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $comment = $response->throw()->json();

        return Comment::fromJson($comment);
    }

    public function create(array $data): Comment
    {
        $url = sprintf('%s/api/v1/ticket_articles', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))
            ->retry(2, 1000)
            ->post($url, $data);

        event(new ZammadResponseLog($response));

        $comment = $response->throw()->json();

        return Comment::fromJson($comment);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))
            ->retry(2, 1000)
            ->delete($url);

        event(new ZammadResponseLog($response));

        $response->throw();
    }
}
