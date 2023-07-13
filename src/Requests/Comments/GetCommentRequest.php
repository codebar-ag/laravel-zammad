<?php

namespace CodebarAg\Zammad\Requests\Comments;

use CodebarAg\Zammad\DTO\Comment;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCommentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/ticket_articles/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): Comment
    {
        return Comment::fromJson($response->json());
    }
}
