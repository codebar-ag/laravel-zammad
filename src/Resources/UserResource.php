<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UserResource
{
    public function me(): User
    {
        $url = sprintf('%s/api/v1/users/me', config('zammad.url'));

        $data = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return User::fromJson($data);
    }

    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $users = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return collect($users)->map(fn (array $user) => User::fromJson($user));
    }

    public function search(string $term): ?User
    {
        $url = sprintf(
            '%s/api/v1/users/search?query=%s&limit=1',
            config('zammad.url'),
            $term,
        );

        $data = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

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

        $data = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return User::fromJson($data);
    }

    public function create(array $data): User
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $user = Http::withToken(config('zammad.token'))
            ->post($url, $data)
            ->throw()
            ->json();

        return User::fromJson($user);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/users/%s',
            config('zammad.url'),
            $id,
        );

        Http::withToken(config('zammad.token'))
            ->delete($url)
            ->throw();
    }

    public function searchOrCreateByEmail(string $email): User
    {
        $user = $this->search("email:{$email}");

        if ($user) {
            return $user;
        }

        return $this->create(['email' => $email]);
    }
}
