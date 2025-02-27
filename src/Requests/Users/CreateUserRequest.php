<?php

namespace CodebarAg\Zammad\Requests\Users;

use CodebarAg\Zammad\DTO\User;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload,
        public bool $expand = false
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => $this->expand,
        ];
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): User
    {
        return User::fromJson($response->json());
    }
}
