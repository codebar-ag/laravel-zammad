<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\Comment;
use CodebarAg\Zammad\Requests\Comments\CreateCommentRequest;
use CodebarAg\Zammad\Requests\Comments\DestroyCommentRequest;
use CodebarAg\Zammad\Requests\Comments\GetCommentByTicketRequest;
use CodebarAg\Zammad\Requests\Comments\GetCommentRequest;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\RequestException;

class CommentResource extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function show(int $id): ?Comment
    {
        $response = self::request(new GetCommentRequest($id));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function showByTicket(int $id): Collection
    {
        $response = self::request(new GetCommentByTicketRequest($id));

        $comments = $response->json();

        return collect($comments)->map(fn (array $comment) => Comment::fromJson($comment));
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function create(array $data): Comment
    {
        $response = self::request(new CreateCommentRequest($data));

        return $response->dtoOrFail();
    }

    public function delete(int $id): void
    {
        self::deleteRequest(new DestroyCommentRequest($id));
    }
}
