<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\User\Infrastructure\Repositories;

use App\TaskManagementSystem\User\Domain\Interfaces\UserRepository;
use App\TaskManagementSystem\User\Domain\UserAggregate;
use App\TaskManagementSystem\User\Domain\UserNotFoundException;
use App\TaskManagementSystem\User\Domain\ValueObjects\ApiToken;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\Uuid;

class MySqlUserRepository implements UserRepository
{
    /**
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function find($apiToken): UserAggregate
    {
        $now = new DateTimeImmutable();
        $hash = ApiToken::hash($apiToken);
        $user = app('db')->table('users')
            ->where('api_token', $hash)
            ->whereDate('token_expiration', '>', $now)
            ->first();
        if ($user === null) {
            throw new UserNotFoundException('not_found');
        }
        $expiration = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $user->token_expiration);
        $apiToken = ApiToken::createFromPersisted(
            $hash,
            $expiration,
        );

        return UserAggregate::create(
            $user->email,
            $user->password,
            $apiToken,
            new DateTimeImmutable($user->created_at),
            new DateTimeImmutable($user->updated_at),
            Uuid::fromString($user->id),
        );
    }

    /**
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function findByEmailAndPassword(string $email, string $password): UserAggregate
    {
        $user = app('db')->table('users')
            ->where('email', $email)
            ->where('password', $password)
            ->first();

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return UserAggregate::create(
            $user->email,
            $user->password,
            null,
            new DateTimeImmutable($user->created_at),
            new DateTimeImmutable($user->updated_at),
            Uuid::fromString($user->id),
        );
    }

    public function save(UserAggregate $userAggregate): void
    {
        $now = new DateTimeImmutable();
        app('db')->table('users')->insert([
            'id' => $userAggregate->id()->toString(),
            'email' => $userAggregate->email(),
            'password' => $userAggregate->password(),
            'api_token' => null,
            'token_expiration' => null,
            'token_has_been_shown' => 0,
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    public function updateToken(UserAggregate $userAggregate): void
    {
        $encryptedToken = ApiToken::hash($userAggregate->apiToken()->token());
        app('db')->table('users')
        ->where('id', $userAggregate->id()->toString())
        ->update([
            'api_token' => $encryptedToken,
            'token_expiration' => $userAggregate->apiToken()->expiration()->format('Y-m-d H:i:s'),
            'token_has_been_shown' => (int) $userAggregate->apiToken()->hasBeenShown(),
            'updated_at' => $userAggregate->updatedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
