<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\Comment as CommentDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Comment
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

        return collect($comment)->map(fn (array $comment) => CommentDTO::fromJson($comment));
    }

    public function show(int $id): ?CommentDTO
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

        return CommentDTO::fromJson($comment);
    }

    public function create(array $data): CommentDTO
    {
        $url = sprintf('%s/api/v1/ticket_articles', config('zammad.url'));

        $comment = Http::withToken(config('zammad.token'))
            ->post($url, $data)
            ->throw()
            ->json();

        return CommentDTO::fromJson($comment);
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
