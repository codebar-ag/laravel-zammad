<?php

namespace CodebarAg\Zammad\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AllUsersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/users';
    }
}
