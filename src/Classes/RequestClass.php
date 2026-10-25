<?php

namespace CodebarAg\Zammad\Classes;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\ZammadConnector;
use Illuminate\Support\Str;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Throwable;

abstract class RequestClass
{
    protected $httpRetryMaxium;

    protected $httpRetryDelay;

    protected $ignoreReferenceErrorIngore;

    protected $objectHasReferenceError;

    protected $connector;

    public function __construct()
    {
        $this->httpRetryMaxium = config('zammad.http_retry_maximum');
        $this->httpRetryDelay = config('zammad.http_retry_delay');

        $this->ignoreReferenceErrorIngore = config('zammad.object_reference_error_ignore');
        $this->objectHasReferenceError = config('zammad.objet_reference_error');

        $this->connector = new ZammadConnector;
    }

    private function performRequest(Request $request, bool $throw = true): Response
    {
        return $this->connector->sendAndRetry(
            $request,
            $this->httpRetryMaxium,
            $this->httpRetryDelay,
            throw: $throw,
        );
    }

    /**
     * @throws RequestException|Throwable
     */
    public function request(Request $request): Response
    {
        $response = $this->performRequest($request);

        event(new ZammadResponseLog($response));

        return $response;
    }

    /**
     * @throws RequestException|Throwable
     */
    public function deleteRequest(Request $request): Response
    {
        // Do not let the retry loop throw on its own: the response has to be
        // inspected first so that the configured reference error can be ignored.
        $response = $this->performRequest($request, throw: false);

        $ignoreReferenceError = [
            'ignore' => $this->ignoreReferenceErrorIngore ? true : false,
            'error' => $response->body() && Str::of($response->body())->contains($this->objectHasReferenceError),
        ];

        $ignoreReferenceErrorStatus = ! in_array(false, $ignoreReferenceError);

        event(new ZammadResponseLog($response));

        return $ignoreReferenceErrorStatus
            ? $response
            : $response->throw();
    }
}
