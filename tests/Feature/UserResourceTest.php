<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

class UserResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /** @test */
    public function it_does_fetch_current_user()
    {
        $user = (new Zammad())->user()->me();

        $this->assertInstanceOf(User::class, $user);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_fetch_a_list_of_users()
    {
        $users = (new Zammad())->user()->list();

        $this->assertInstanceOf(Collection::class, $users);
        $users->each(function (User $user) {
            $this->assertInstanceOf(User::class, $user);
        });
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_search_user()
    {
        $term = 'email:ruslan.steiger@codebar.ch';

        $user = (new Zammad())->user()->search($term);

        $this->assertInstanceOf(User::class, $user);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_search_user_with_empty_result()
    {
        $term = 'email:does@not.exist';

        $user = (new Zammad())->user()->search($term);

        $this->assertNull($user);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_show_user()
    {
        $id = 20;

        $user = (new Zammad())->user()->show($id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($id, $user->id);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_create_and_delete_user()
    {
        $data = [
            'firstname' => 'Noah',
            'lastname' => 'Schweizer',
            'email' => rand().'noah@schweizer.ch',
        ];

        $user = (new Zammad())->user()->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Noah', $user->first_name);
        $this->assertSame('Schweizer', $user->last_name);
        $this->assertStringEndsWith('noah@schweizer.ch', $user->email);
        Event::assertDispatched(ZammadResponseLog::class, 1);

        (new Zammad())->user()->delete($user->id);
        Event::assertDispatched(ZammadResponseLog::class, 2);
    }

    /** @test */
    public function it_does_search_or_create_user_by_email()
    {
        $email = rand().'noah@schweizer.ch';

        $user = (new Zammad())->user()->searchOrCreateByEmail($email);

        $this->assertSame($email, $user->email);
        Event::assertDispatched(ZammadResponseLog::class, 2);
        (new Zammad())->user()->delete($user->id);
        Event::assertDispatched(ZammadResponseLog::class, 3);
    }
}
