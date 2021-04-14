<?php

namespace CodebarAg\Zammad;

use CodebarAg\Zammad\Resources\AttachmentResource;
use CodebarAg\Zammad\Resources\CommentResource;
use CodebarAg\Zammad\Resources\ObjectResource;
use CodebarAg\Zammad\Resources\TicketResource;
use CodebarAg\Zammad\Resources\UserResource;

class Zammad
{
    public function user(): UserResource
    {
        return new UserResource();
    }

    public function ticket(): TicketResource
    {
        return new TicketResource();
    }

    public function comment(): CommentResource
    {
        return new CommentResource();
    }

    public function attachment(): AttachmentResource
    {
        return new AttachmentResource();
    }

    public function object(): ObjectResource
    {
        return new ObjectResource();
    }
}
