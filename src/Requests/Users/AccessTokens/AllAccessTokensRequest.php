<?php

namespace CodebarAg\Zammad\Requests\Users\AccessTokens;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AllAccessTokensRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user_access_token';
    }
}
