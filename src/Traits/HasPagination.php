<?php

namespace CodebarAg\Zammad\Traits;

trait HasPagination
{
    public int $page = 1;

    public int $perPage = 1;

    public function paginate(int $page, int $perPage): self
    {
        $this->page = $page;
        $this->perPage = $perPage;

        return $this;
    }
}
