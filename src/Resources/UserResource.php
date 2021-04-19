<?php

namespace CodebarAg\Zammad\Resources;

use CodebarAg\Zammad\DTO\User;
use CodebarAg\Zammad\Events\ZammadResponseLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UserResource
{
    public function me(): User
    {
        $url = sprintf('%s/api/v1/users/me', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $data = $response->throw()->json();

        return User::fromJson($data);
    }

    public function list(): Collection
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $users = $response->throw()->json();

        return collect($users)->map(fn (array $user) => User::fromJson($user));
    }

    public function search(string $term): ?User
    {
        $url = sprintf(
            '%s/api/v1/users/search?query=%s&limit=1',
            config('zammad.url'),
            $term,
        );

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $data = $response->throw()->json();

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

        $response = Http::withToken(config('zammad.token'))->get($url);

        event(new ZammadResponseLog($response));

        $data = $response->throw()->json();

        return User::fromJson($data);
    }

    public function create(array $data): User
    {
        $url = sprintf('%s/api/v1/users', config('zammad.url'));

        $response = Http::withToken(config('zammad.token'))->post($url, $data);

        event(new ZammadResponseLog($response));

        $user = $response->throw()->json();

        return User::fromJson($user);
    }

    public function delete(int $id): void
    {
        $url = sprintf(
            '%s/api/v1/users/%s',
            config('zammad.url'),
            $id,
        );

        $response = Http::withToken(config('zammad.token'))->delete($url);

        event(new ZammadResponseLog($response));

        $response->throw();
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
