<?php

namespace CodebarAg\Zammad\Requests\ObjectAttribute;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetObjectAttributeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/object_manager_attributes/'.$this->id;
    }
}
