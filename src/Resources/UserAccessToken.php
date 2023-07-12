<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\Requests\Users\AccessTokens\AllAccessTokensRequest;
use CodebarAg\Zammad\Requests\Users\AccessTokens\CreateAccessTokenRequest;
use CodebarAg\Zammad\Requests\Users\CreateUserRequest;
use Saloon\Exceptions\Request\RequestException;

class UserAccessToken extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function list()
    {
        $request = new AllAccessTokensRequest;

        $response = self::getRequest($request);

        return $response->json();
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function create(array $data)
    {
        $request = new CreateAccessTokenRequest($data);

        $response = self::postRequest($request);

        return $response->json();
    }

    public function delete($id)
    {
        $url = sprintf('%s/api/v1/user_access_token/%s', config('zammad.url'), $id);

        $response = self::deleteRequest($url);

        return $response->json();
    }
}
