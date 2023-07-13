<?php

namespace CodebarAg\Zammad\Requests\ObjectAttribute;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateObjectAttributeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        public int $id,
        public array $payload
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/object_manager_attributes/'.$this->id;
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
