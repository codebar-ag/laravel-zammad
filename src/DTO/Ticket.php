<?php

namespace CodebarAg\Zammad\DTO;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class Ticket
{
    public static function fromJson(array $data): self
    {
        return new self(
            id: $data['id'],
            number: $data['number'],
            user_id: $data['customer_id'],
            group_id: $data['group_id'],
            state_id: $data['state_id'],
            subject: $data['title'],
            comments_count: Arr::get($data, 'article_count', 0) ?? 0,
            updated_at: Carbon::parse($data['updated_at']),
            created_at: Carbon::parse($data['created_at']),
        );
    }

    public function __construct(
        public int $id,
        public int $number,
        public int $user_id,
        public int $group_id,
        public int $state_id,
        public string $subject,
        public int $comments_count,
        public Carbon $updated_at,
        public Carbon $created_at,
    ) {
    }

    public function state(): string
    {
        return match($this->state_id) {
            1 => 'new',
            2 => 'open',
            3 => 'pending_reminder',
            4 => 'closed',
            5 => 'merged',
            6 => 'removed',
            7 => 'pending_close',
        };
    }

    public function isOpen(): bool
    {
        return in_array($this->state_id, [1, 2, 3, 7]);
    }

    public function isClosed(): bool
    {
        return in_array($this->state_id, [4]);
    }

    public function isActive(): bool
    {
        return in_array($this->state_id, [1, 2, 3, 4, 7]);
    }

    public function isInactive(): bool
    {
        return in_array($this->state_id, [5, 6]);
    }

    public static function fake(
        ?int $id = null,
        ?int $number = null,
        ?int $user_id = null,
        ?int $group_id = null,
        ?int $state_id = null,
        ?string $subject = null,
        ?int $comments_count = null,
        ?Carbon $updated_at = null,
        ?Carbon $created_at = null,
    ): self {
        return new self(
            id: $id ?? random_int(1, 1000),
            number: $number ?? random_int(10000, 99999),
            user_id: $user_id ?? 1,
            group_id: $group_id ?? 1,
            state_id: $state_id ?? random_int(1, 7),
            subject: $subject ?? 'Fake subject',
            comments_count: $comments_count ?? 0,
            updated_at: $updated_at ?? now(),
            created_at: $created_at ?? now()->subDay(),
        );
    }
}
