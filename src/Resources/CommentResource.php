<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\Comment;
use Illuminate\Support\Collection;

class CommentResource extends RequestClass
{
    public function showByTicket(int $id): Collection
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/by_ticket/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $comment = $response->json();

        return collect($comment)->map(fn(array $comment) => Comment::fromJson($comment));
    }

    public function show(int $id): ?Comment
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $comment = $response->json();

        return Comment::fromJson($comment);
    }

    public function create(array $data): Comment
    {
        $url = sprintf('%s/api/v1/ticket_articles', config('zammad.url'));

        $response = self::postRequest($url, $data);

        $comment = $response->json();

        return Comment::fromJson($comment);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/ticket_articles/%s',
            config('zammad.url'),
            $id,
        );

        self::deleteRequest($url);
    }
}
