<?php

namespace CodebarAg\Zammad\DTO;

class Attachment
{
    public static function fromJson(array $data): self
    {
        $type = $data['preferences'];

        return new static(
            id: $data['id'],
            size: $data['size'],
            name: $data['filename'],
            type: $type['Content-Type'] ?? $type['Mime-Type'],
        );
    }

    public function __construct(
        public int $id,
        public int $size,
        public string $name,
        public string $type,
    ) {
    }

    public static function fake(
        ?int $id = null,
        ?int $size = null,
        ?string $name = null,
        ?string $type = null,
    ): self {
        return new static(
            id: $id ?? random_int(1, 9999),
            size: $size ?? 30,
            name: $name ?? 'fake.txt',
            type: $type ?? 'text/plain',
        );
    }
}
