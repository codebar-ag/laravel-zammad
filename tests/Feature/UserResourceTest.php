<?php

namespace CodebarAg\Zammad\Tests\Feature;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use CodebarAg\Zammad\Tests\TestCase;
use CodebarAg\Zammad\Zammad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

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
        $term = 'email:sebastian.fix@codebar.ch';

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

    /** @test
     * @group zammad
     */
    public function it_does_show_user()
    {
        $id = 4;

        $user = (new Zammad())->user()->show($id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($id, $user->id);
        Event::assertDispatched(ZammadResponseLog::class, 1);
    }

    /** @test */
    public function it_does_create_and_delete_user()
    {
        $firstname = 'Max';
        $lastname = 'Mustermann';
        $email = time().'-'.Str::orderedUuid()->toString().'@codebar.ch';

        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
        ];

        $user = (new Zammad())->user()->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($firstname, $user->first_name);
        $this->assertSame($lastname, $user->last_name);
        $this->assertStringEndsWith($email, $user->email);
        Event::assertDispatched(ZammadResponseLog::class, 1);

        (new Zammad())->user()->delete($user->id);
        Event::assertDispatched(ZammadResponseLog::class, 2);
    }

    /** @test */
    public function it_does_search_or_create_user_by_email()
    {
        $email = time().'-'.Str::orderedUuid()->toString().'@codebar.ch';

        $user = (new Zammad())->user()->searchOrCreateByEmail($email);

        $this->assertSame($email, $user->email);
        Event::assertDispatched(ZammadResponseLog::class, 2);
        (new Zammad())->user()->delete($user->id);
        Event::assertDispatched(ZammadResponseLog::class, 3);
    }
}
