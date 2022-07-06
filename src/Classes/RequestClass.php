<?php

namespace CodebarAg\Zammad\Classes;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class RequestClass
{
    protected $httpRetryMaxium;
    protected $httpRetryDelay;

    public function __construct()
    {
        $this->httpRetryMaxium = config('zammad.http_retry_maximum');
        $this->httpRetryDelay = config('zammad.http_retry_delay');
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getRequest($url): Response
    {
        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->get($url);

        event(new ZammadResponseLog($response));

        return $response->throw();
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function postRequest($url, $data = null): Response
    {
        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->post($url, $data);

        event(new ZammadResponseLog($response));

        return $response->throw();
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function putRequest($url, $data): Response
    {
        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->put($url, $data);

        event(new ZammadResponseLog($response));

        return $response->throw();
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function deleteRequest($url): Response
    {
        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->delete($url);

        event(new ZammadResponseLog($response));

        return $response->throw();
    }

}
