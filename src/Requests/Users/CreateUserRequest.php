<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
