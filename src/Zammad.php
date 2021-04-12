<?php

namespace CodebarAg\Zammad;

use CodebarAg\Zammad\Resources\Comment;
use CodebarAg\Zammad\Resources\Ticket;
use CodebarAg\Zammad\Resources\User;

class Zammad
{
    public function user(): User
    {
        return new User();
    }

    public function ticket(): Ticket
    {
        return new Ticket();
    }

    public function comment(): Comment
    {
        return new Comment();
    }
}
