<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        public int $id,
        public array $payload
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users/' . $this->id;
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
