<?php

namespace CodebarAg\Zammad\Traits;

trait HasLimit
{
    public ?int $limit = null;

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}
