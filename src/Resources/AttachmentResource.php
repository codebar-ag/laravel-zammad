<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Support\Facades\Http;

class AttachmentResource
{
    protected $httpRetryMaxium;
    protected $httpRetryDelay;

    public function __construct()
    {
        $this->httpRetryMaxium = config('zammad.http_retry_maximum');
        $this->httpRetryDelay = config('zammad.http_retry_delay');
    }

    public function download(
        int $ticketId,
        int $commentId,
        int $attachmentId,
    ): string {
        $url = sprintf(
            '%s/api/v1/ticket_attachment/%s/%s/%s',
            config('zammad.url'),
            $ticketId,
            $commentId,
            $attachmentId,
        );

        $response = Http::withToken(config('zammad.token'))
            ->retry($this->httpRetryMaxium, $this->httpRetryDelay)
            ->get($url);

        event(new ZammadResponseLog($response));

        return $response->throw()->body();
    }
}
