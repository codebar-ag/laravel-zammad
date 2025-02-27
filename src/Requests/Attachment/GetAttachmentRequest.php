<?php

namespace CodebarAg\Zammad\Requests\Attachment;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAttachmentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public int $ticketId,
        public int $commentId,
        public int $attachmentId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ticket_attachment/'.$this->ticketId.'/'.$this->commentId.'/'.$this->attachmentId;
    }
}
