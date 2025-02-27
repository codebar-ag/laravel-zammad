<?php

namespace CodebarAg\Zammad\Requests\AccessTokens;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateAccessTokenRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload
    ) {}

    public function resolveEndpoint(): string
    {
        return '/user_access_token';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
