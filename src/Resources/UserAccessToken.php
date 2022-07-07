<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;

class UserAccessToken extends RequestClass
{
    public function list()
    {
        $url = sprintf('%s/api/v1/user_access_token', config('zammad.url'));
        $response = self::getRequest($url);

        return $response->json();
    }

    public function createOnBehalfOf(int $id, array $data)
    {
        $url = sprintf('%s/api/v1/user_access_token', config('zammad.url'));
        $response = self::postRequestOnBehalf($id, $url, $data);

        return $response->json();
    }

    public function create(array $data)
    {
        $url = sprintf('%s/api/v1/user_access_token', config('zammad.url'));
        $response = self::postRequest($url, $data);

        return $response->json();
    }

    public function delete($id)
    {
        $url = sprintf('%s/api/v1/user_access_token/%s', config('zammad.url'), $id);

        $response = self::deleteRequest($url);

        return $response->json();
    }
}
