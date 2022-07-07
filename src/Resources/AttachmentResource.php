<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;

class AttachmentResource extends RequestClass
{
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

        $response = self::getRequest($url);

        return $response->body();
    }
}
