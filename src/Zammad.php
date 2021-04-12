<?php

namespace CodebarAg\Zammad;

use CodebarAg\Zammad\Resources\User;

class Zammad
{
    public function user(): User
    {
        return new User();
    }
}
