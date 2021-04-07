<?php

namespace CodebarAg\Zammad\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodebarAg\Zammad\Zammad
 */
class Zammad extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Zammad::class;
    }
}
