<?php

namespace CodebarAg\Zammad\Requests\Users;

use CodebarAg\Zammad\DTO\User;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class UpdateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        public int $id,
        public array $payload,
        public bool $expand = false
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users/'.$this->id;
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
