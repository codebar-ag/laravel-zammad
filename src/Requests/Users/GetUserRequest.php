<?php

namespace CodebarAg\Zammad\Requests\Users;

use CodebarAg\Zammad\DTO\User;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $id = null,
        public bool $expand = false
    ) {}

    public function resolveEndpoint(): string
    {
        $endpoint = '/users/';

        if ($this->id) {
            return $endpoint.$this->id;
        }

        return $endpoint.'me';
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromJson($response->json(), $this->expand);
    }
}
