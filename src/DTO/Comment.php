<?php

namespace CodebarAg\Zammad\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property Collection|Attachment[] $attachments
 */
class Comment
{
    public static function fromJson(array $data): self
    {
        $attachments = collect($data['attachments'])
            ->map(function (array $attachment) use ($data) {
                return Attachment::fromJson(
                    data: $attachment,
                    ticketId: $data['ticket_id'],
                    commentId: $data['id'],
                );
            });

        $bodyWithoutBlockquote = Str::of($data['body'])
            ->before('<span class="js-signatureMarker"></span>')
            ->__toString();
        $bodyOnlyBlockquote = Str::of($data['body'])
            ->after('<span class="js-signatureMarker"></span>')
            ->__toString();

        return new self(
            id: $data['id'],
            type_id: $data['type_id'],
            ticket_id: $data['ticket_id'],
            sender_id: $data['sender_id'],
            subject: $data['subject'],
            body: $data['body'],
            body_without_blockquote: $bodyWithoutBlockquote,
            body_only_blockquote: $bodyOnlyBlockquote,
            content_type: $data['content_type'],
            from: $data['from'],
            to: $data['to'],
            internal: $data['internal'],
            created_by_id: $data['created_by_id'],
            updated_by_id: $data['updated_by_id'],
            origin_by_id: $data['origin_by_id'],
            attachments: $attachments,
            updated_at: Carbon::parse($data['updated_at']),
            created_at: Carbon::parse($data['created_at']),
        );
    }

    public function __construct(
        public int $id,
        public int $type_id,
        public int $ticket_id,
        public int $sender_id,
        public ?string $subject,
        public string $body,
        public string $body_without_blockquote,
        public ?string $body_only_blockquote,
        public string $content_type,
        public string $from,
        public ?string $to,
        public bool $internal,
        public int $created_by_id,
        public int $updated_by_id,
        public int $origin_by_id,
        public Collection $attachments,
        public Carbon $updated_at,
        public Carbon $created_at,
    ) {
    }

    public static function fake(
        ?int $id = null,
        ?int $type_id = null,
        ?int $ticket_id = null,
        ?int $sender_id = null,
        ?string $subject = null,
        ?string $body = null,
        ?string $content_type = null,
        ?string $from = null,
        ?string $to = null,
        ?bool $internal = null,
        ?int $created_by_id = null,
        ?int $updated_by_id = null,
        ?int $origin_by_id = null,
        ?Carbon $updated_at = null,
        ?Carbon $created_at = null,
    ): self {
        return new self(
            id: $id ?? random_int(1, 1000),
            type_id: $type_id ?? 10,
            ticket_id: $ticket_id ?? 1,
            sender_id: $sender_id ?? 1,
            subject: $subject ?? 'Fake subject',
            body: $body ?? 'Fake body',
            body_without_blockquote: $body ?? 'Fake body without blockquote',
            body_only_blockquote: $body ?? 'Fake body only blockquote',
            content_type: $content_type ?? 'text/html',
            from: $from ?? 'Fake User',
            to: $to ?? 'Fake User',
            internal: $internal ?? false,
            created_by_id: $created_by_id ?? 1,
            updated_by_id: $updated_by_id ?? 1,
            origin_by_id: $origin_by_id ?? 1,
            attachments: collect([Attachment::fake()]),
            updated_at: $updated_at ?? now(),
            created_at: $created_at ?? now()->subDay(),
        );
    }
}
