<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\Requests\Attachment\GetAttachmentRequest;
use Saloon\Exceptions\Request\RequestException;

class AttachmentResource extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     */
    public function download(
        int $ticketId,
        int $commentId,
        int $attachmentId,
    ): string {
        $response = self::request(new GetAttachmentRequest($ticketId, $commentId, $attachmentId));

        return $response->body();
    }
}
