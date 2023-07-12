<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Requests\Users\AllUsersRequest;
use CodebarAg\Zammad\Requests\Users\CreateUserRequest;
use CodebarAg\Zammad\Requests\Users\DestroyUserRequest;
use CodebarAg\Zammad\Requests\Users\GetUserRequest;
use CodebarAg\Zammad\Requests\Users\SearchUserRequest;
use CodebarAg\Zammad\Requests\Users\UpdateUserRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\RequestException;

class UserResource extends RequestClass
{
    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function me(): User
    {
        $request = new GetUserRequest;

        $response = self::getRequest($request);

        $data = $response->json();

        return User::fromJson($data);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function list(): Collection
    {
        $request = new AllUsersRequest;

        $response = self::getRequest($request);

        $users = $response->json();

        return collect($users)->map(fn (array $user) => User::fromJson($user));
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function search(string $term): ?User
    {
        $request = new SearchUserRequest($term);

        $response = self::getRequest($request);

        $data = $response->json();

        return Arr::exists($data, 0)
            ? User::fromJson($data[0])
            : null;
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function show(int $id): User
    {
        $request = new GetUserRequest($id);

        $response = self::getRequest($request);

        $data = $response->json();

        return User::fromJson($data);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function create(array $data): User
    {
        $request = new CreateUserRequest($data);

        $response = self::postRequest($request);

        $user = $response->json();

        return User::fromJson($user);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     * @throws \JsonException
     */
    public function update($id, array $data): User
    {
        $request = new UpdateUserRequest($id, $data);

        $response = self::putRequest($request);

        $user = $response->json();

        return User::fromJson($user);
    }

    /**
     * @throws \Throwable
     * @throws RequestException
     */
    public function delete(int $id): void
    {
        $request = new DestroyUserRequest($id);

        self::deleteRequest($request);
    }

    /**
     * @throws \JsonException
     * @throws \Throwable
     * @throws RequestException
     */
    public function searchOrCreateByEmail(string $email, array $data = []): User
    {
        $user = $this->search("email:{$email}");

        if ($user) {
            return $user;
        }

        if (array_key_exists('email', $data)) {
            return $this->create($data);
        }

        return $this->create(['email' => $email]);
    }
}
