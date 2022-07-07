<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserAccessToken extends RequestClass
{
    public function me(): User
    {
        $url = sprintf('%s/api/v1/users/me', config('zammad.url'));

        $response = self::getRequest($url);

        $data = $response->json();

        return User::fromJson($data);
    }
}
