<?php

namespace CodebarAg\Zammad\Requests\ObjectAttribute;

use CodebarAg\Zammad\DTO\ObjectAttribute;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateObjectAttributeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload
    ) {}

    public function resolveEndpoint(): string
    {
        return '/object_manager_attributes';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function createDtoFromResponse(Response $response): ObjectAttribute
    {
        return ObjectAttribute::fromJson($response->json());
    }
}
