<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\Requests\Users\AccessTokens\AllAccessTokensRequest;
use CodebarAg\Zammad\Requests\Users\AccessTokens\CreateAccessTokenRequest;
use CodebarAg\Zammad\Requests\Users\AccessTokens\DestroyAccessTokenRequest;
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
        $response = self::request(new AllAccessTokensRequest);

        return $response->json();
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function create(array $data)
    {
        $response = self::request(new CreateAccessTokenRequest($data));

        return $response->json();
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function delete($id)
    {
        $response = self::deleteRequest(new DestroyAccessTokenRequest($id));

        return $response->json();
    }
}
