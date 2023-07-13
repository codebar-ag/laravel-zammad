<?php

namespace CodebarAg\Zammad\Requests\Users;

use CodebarAg\Zammad\DTO\User;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $id = null
    ) {
    }

    public function resolveEndpoint(): string
    {
        $endpoint = '/users/';

        if ($this->id) {
            return $endpoint.$this->id;
        }

        return $endpoint.'me';
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromJson($response->json());
    }
}