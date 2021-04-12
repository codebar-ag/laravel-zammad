<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\User as UserDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class User
{
    public function me(): UserDTO
    {
        $url = sprintf('%s/api/v1/users/me', config('zammad.url'));

        $data = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return UserDTO::fromJson($data);
    }

    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $users = Http::withToken(config('zammad.token'))
            ->get($url)
            ->throw()
            ->json();

        return collect($users)->map(fn (array $user) => UserDTO::fromJson($user));
    }

    public function search(string $term): UserDTO
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

        return UserDTO::fromJson($data[0]);
    }

    public function show(int $id): UserDTO
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

        return UserDTO::fromJson($data);
    }

    public function create(array $data): UserDTO
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $data = Http::withToken(config('zammad.token'))
            ->post($url, $data)
            ->throw()
            ->json();

        return UserDTO::fromJson($data);
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
}
