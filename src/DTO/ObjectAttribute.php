<?php

namespace CodebarAg\Zammad\DTO;

class ObjectAttribute
{
    public static function fromJson(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            object_lookup_id: $data['object_lookup_id'],
            display: $data['display'],
            data_type: $data['data_type'],
            position: $data['position'],
            data_option: $data['data_option'],
            data_option_new: $data['data_option_new'],
        );
    }

    public function __construct(
        public int $id,
        public string $name,
        public int $object_lookup_id,
        public string $display,
        public string $data_type,
        public int $position,
        public array $data_option,
        public array $data_option_new,
    ) {
    }

    public static function fake(
        ?int $id = null,
        ?int $name = null,
        ?int $object_lookup_id = null,
        ?string $display = null,
        ?string $data_type = null,
        ?int $position = null,
        ?array $data_option = null,
        ?array $data_option_new = null,
    ): self {
        return new self(
            id: $id ?? random_int(1, 1000),
            name: $name ?? 'sample_boolean',
            object_lookup_id: $object_lookup_id ?? random_int(1, 10),
            display: $display ?? 'Sample Boolean',
            data_type: $data_type ?? 'boolean',
            position: $position ?? random_int(1, 1000),
            data_option: $data_option ?? ['options' => ['true' => 'yes', 'false' => 'no'], 'default' => 'false'],
            data_option_new: $data_option_new ?? [],
        );
    }
}
