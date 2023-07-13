<?php

namespace CodebarAg\Zammad\Traits;

trait HasLimit
{
    public int $limit = 1;

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}
