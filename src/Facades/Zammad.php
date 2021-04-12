<?php

namespace CodebarAg\Zammad\Facades;

use CodebarAg\Zammad\Resources\Ticket;
use CodebarAg\Zammad\Resources\User;
use Illuminate\Support\Facades\Facade;

/**
 * @see \CodebarAg\Zammad\Zammad
 *
 * @method static User user()
 * @method static Ticket ticket()
 */
class Zammad extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Zammad::class;
    }
}
