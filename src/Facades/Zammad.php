<?php

namespace CodebarAg\Zammad\Facades;

use CodebarAg\Zammad\Resources\AttachmentResource;
use CodebarAg\Zammad\Resources\CommentResource;
use CodebarAg\Zammad\Resources\ObjectResource;
use CodebarAg\Zammad\Resources\TicketResource;
use CodebarAg\Zammad\Resources\UserResource;
use Illuminate\Support\Facades\Facade;

/**
 * @see \CodebarAg\Zammad\Zammad
 *
 * @method static UserResource user()
 * @method static TicketResource ticket()
 * @method static CommentResource comment()
 * @method static AttachmentResource attachment()
 * @method static ObjectResource object()
 */
class Zammad extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Zammad::class;
    }
}
