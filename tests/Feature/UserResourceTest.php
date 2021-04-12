<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;

class UserResourceTest extends TestCase
{
    /** @test */
    public function it_does_fetch_current_user()
    {
        $user = (new Zammad())->user()->me();

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function it_does_fetch_a_list_of_users()
    {
        $users = (new Zammad())->user()->list();

        $this->assertInstanceOf(Collection::class, $users);
        $users->each(function (User $user) {
            $this->assertInstanceOf(User::class, $user);
        });
    }

    /** @test */
    public function it_does_search_user()
    {
        $term = 'email:ruslan.steiger@codebar.ch';

        $user = (new Zammad())->user()->search($term);

        $this->assertInstanceOf(User::class, $user);
    }

    /** @test */
    public function it_does_search_user_with_empty_result()
    {
        $term = 'email:does@not.exist';

        $user = (new Zammad())->user()->search($term);

        $this->assertNull($user);
    }

    /** @test */
    public function it_does_show_user()
    {
        $id = 20;

        $user = (new Zammad())->user()->show($id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(20, $user->id);
    }

    /** @test */
    public function it_does_create_and_delete_user()
    {
        $data = [
            'firstname' => 'Noah',
            'lastname' => 'Schweizer',
            'email' => 'noah@schweizer.ch',
        ];

        $user = (new Zammad())->user()->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Noah', $user->first_name);
        $this->assertSame('Schweizer', $user->last_name);
        $this->assertSame('noah@schweizer.ch', $user->email);

        (new Zammad())->user()->delete($user->id);
    }
}
