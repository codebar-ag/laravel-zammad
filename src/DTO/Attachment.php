<?php

namespace CodebarAg\Zammad\DTO;

use Illuminate\Support\Arr;

class Attachment
{
    public static function fromJson(array $data): self
    {
        return new static(
            id: $data['id'],
            size: $data['size'],
            name: $data['filename'],
            content_type: Arr::get($data, 'preferences.Mime-Type'),
        );
    }

    public function __construct(
        public int $id,
        public int $size,
        public string $name,
        public string $content_type,
    ) {
    }

    public static function fake(
        ?int $id = null,
        ?int $size = null,
        ?string $name = null,
        ?string $content_type = null,
    ): self {
        return new static(
            id: $id ?? random_int(1, 9999),
            size: $size ?? 30,
            name: $name ?? 'fake.txt',
            content_type: $content_type ?? 'text/plain',
        );
    }
}
