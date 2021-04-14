<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\Comment;
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

        $comment = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return collect($comment)->map(fn (array $comment) => Comment::fromJson($comment));
    }

    public function show(int $id): ?Comment
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        $comment = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return Comment::fromJson($comment);
    }

    public function create(array $data): Comment
    {
        $url = sprintf('%s/api/v1/ticket_articles', config('zammad.url'));

        $comment = Http::withToken(config('zammad.token'))
            ->post($url, $data)
            ->throw()
            ->json();

        return Comment::fromJson($comment);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        Http::withToken(config('zammad.token'))
            ->delete($url)
            ->throw();
    }
}
