<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\Classes\RequestClass;
use CodebarAg\Zammad\DTO\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserResource extends RequestClass
{
    public function me(): User
    {
        $url = sprintf('%s/api/v1/users/me', config('zammad.url'));

        $response = self::getRequest($url);

        $data = $response->json();

        return User::fromJson($data);
    }

    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $response = self::getRequest($url);

        $users = $response->json();

        return collect($users)->map(fn(array $user) => User::fromJson($user));
    }

    public function search(string $term): ?User
    {
        $url = sprintf(
            '%s/api/v1/users/search?query=%s&limit=1',
            config('zammad.url'),
            $term,
        );

        $response = self::getRequest($url);

        $data = $response->json();

        return Arr::exists($data, 0)
            ? User::fromJson($data[0])
            : null;
    }

    public function show(int $id): User
    {
        $url = sprintf(
            '%s/api/v1/users/%s',
            config('zammad.url'),
            $id,
        );

        $response = self::getRequest($url);

        $data = $response->json();

        return User::fromJson($data);
    }

    public function create(array $data): User
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $response = self::postRequest($url, $data);

        $user = $response->json();

        return User::fromJson($user);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/users/%s',
            config('zammad.url'),
            $id,
        );

        self::deleteRequest($url);
    }

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
