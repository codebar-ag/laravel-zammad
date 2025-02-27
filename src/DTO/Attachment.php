<?php

namespace CodebarAg\Zammad\DTO;

class Attachment
{
    public static function fromJson(
        array $data,
        int $ticketId,
        int $commentId,
    ): self {
        $type = $data['preferences'];

        return new self(
            id: $data['id'],
            ticket_id: $ticketId,
            comment_id: $commentId,
            size: $data['size'],
            name: $data['filename'],
            type: $type['Content-Type'] ?? $type['Mime-Type'],
        );
    }

    public function __construct(
        public int $id,
        public int $ticket_id,
        public int $comment_id,
        public int $size,
        public string $name,
        public string $type,
    ) {}

    public function url(): string
    {
        return sprintf(
            '%s/api/v1/ticket_attachment/%s/%s/%s',
            config('zammad.url'),
            $this->ticket_id,
            $this->comment_id,
            $this->id,
        );
    }

    public static function fake(
        ?int $id = null,
        ?int $ticketId = null,
        ?int $commentId = null,
        ?int $size = null,
        ?string $name = null,
        ?string $type = null,
    ): self {
        return new self(
            id: $id ?? random_int(1, 9999),
            ticket_id: $ticketId ?? random_int(1, 9999),
            comment_id: $commentId ?? random_int(1, 9999),
            size: $size ?? 30,
            name: $name ?? 'fake.txt',
            type: $type ?? 'text/plain',
        );
    }
}
