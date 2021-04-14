<?php

namespace CodebarAg\Zammad\Resources;

use Illuminate\Support\Facades\Http;

class Attachment
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

        return Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->body();
    }
}
