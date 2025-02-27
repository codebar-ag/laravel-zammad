<?php

namespace CodebarAg\Zammad\Requests\Comments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCommentByTicketRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ticket_articles/by_ticket/'.$this->id;
    }
}
