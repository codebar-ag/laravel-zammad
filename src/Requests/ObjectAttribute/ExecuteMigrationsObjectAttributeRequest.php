<?php

namespace CodebarAg\Zammad\Requests\ObjectAttribute;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ExecuteMigrationsObjectAttributeRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/object_manager_attributes_execute_migrations';
    }
}
