<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Tests\TestCase;

class DTOTest extends TestCase
{
    /** @test */
    public function it_does_create_a_fake_user()
    {
        $user = User::fake();

        $this->assertInstanceOf(User::class, $user);
    }
}
