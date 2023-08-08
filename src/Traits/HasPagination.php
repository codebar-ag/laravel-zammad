<?php

namespace CodebarAg\Zammad\Traits;

trait HasPagination
{
    public ?int $page = null;

    public ?int $perPage = null;

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function paginate(int $page, int $perPage): self
    {
        $this->page = $page;
        $this->perPage = $perPage;

        return $this;
    }
}
