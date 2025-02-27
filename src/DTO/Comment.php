<?php

namespace CodebarAg\Zammad\DTO;

use Carbon\Carbon;
use Illuminate\Support\Arr;
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

        $filterImages = config('zammad.filter_images');
        $filterTables = config('zammad.filter_tables');
        $filterSigantureMarker = config('zammad.filter_signature_marker');
        $filterSigantureMarkerValue = config('zammad.filter_signature_marker_value');
        $filterDataSignature = config('zammad.filter_data_signature');
        $filterDataSignatureValue = config('zammad.filter_data_signature_value');

        $bodyFiltered = $data['body'];

        if ($filterImages) {
            $bodyFiltered = preg_replace("/<img[^>]+\>/i", '$1', $bodyFiltered);
        }

        if ($filterTables) {
            $bodyFiltered = preg_replace("/<table[^>]+\>/i", '$1', $bodyFiltered);
        }

        if ($filterSigantureMarker) {
            $bodyFiltered = Str::of($bodyFiltered)->before($filterSigantureMarkerValue)->toString();
        }

        if ($filterDataSignature) {
            $bodyFiltered = Str::of($bodyFiltered)->before($filterDataSignatureValue)->toHtmlString().'</div>';
        }

        return new self(
            id: $data['id'],
            type_id: $data['type_id'],
            ticket_id: $data['ticket_id'],
            sender_id: $data['sender_id'],
            sender: $data['sender'],
            subject: $data['subject'],
            body: $data['body'],
            body_filtered: $bodyFiltered,
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
        public string $sender,
        public ?string $subject,
        public string $body,
        public string $body_filtered,
        public string $content_type,
        public string $from,
        public ?string $to,
        public bool $internal,
        public int $created_by_id,
        public int $updated_by_id,
        public ?int $origin_by_id,
        public Collection $attachments,
        public Carbon $updated_at,
        public Carbon $created_at,
    ) {}

    public static function fake(
        ?int $id = null,
        ?int $type_id = null,
        ?int $ticket_id = null,
        ?int $sender_id = null,
        ?string $sender = null,
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
            sender: $sender ?? Arr::random(['Agent', 'Customer']),
            subject: $subject ?? 'Fake subject',
            body: $body ?? 'Fake body',
            body_filtered: $body ?? 'Fake body with filtered blockquote',
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

    public function fromName(): string
    {
        return Str::before(Str::between($this->from, '"', '"'), '<');
    }

    public function fromEmail(): string
    {
        return Str::between($this->from, '<', '>');
    }
}
