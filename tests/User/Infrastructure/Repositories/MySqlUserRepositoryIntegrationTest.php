<?php

declare(strict_types=1);

namespace Tests\User\Infrastructure\Repositories;

use App\TaskManagementSystem\User\Domain\UserAggregate;
use App\TaskManagementSystem\User\Domain\ValueObjects\ApiToken;
use App\TaskManagementSystem\User\Infrastructure\Repositories\MySqlUserRepository;
use DateTimeImmutable;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class MySqlUserRepositoryIntegrationTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;

    public function test_find_by_email_and_password(): void
    {
        $repository = new MySqlUserRepository();
        $createdUser = $this->createUser();
        $foundUser = $repository->findByEmailAndPassword($createdUser->email(), $createdUser->password());
        $this->assertInstanceOf(UserAggregate::class, $foundUser);
    }

    public function test_find(): void
    {
        $now = new DateTimeImmutable();
        $repository = new MySqlUserRepository();
        $createdUser = $this->createUser();
        $newToken = ApiToken::create();
        $token = $newToken->showToUser();
        $user = UserAggregate::create(
            $createdUser->email(),
            $createdUser->password(),
            $newToken,
            $createdUser->createdAt(),
            $now,
            $createdUser->id(),
        );
        $repository->updateToken($user);
        $foundUser = $repository->find($token);
        $this->assertInstanceOf(UserAggregate::class, $foundUser);
    }

    public function test_save(): void
    {
        $createdUser = $this->createUser();
        $this->seeInDatabase('users', [
            'id' => $createdUser->id()->toString()
        ]);
    }

    public function test_update_token(): void
    {
        $repository = new MySqlUserRepository();
        $createdUser = $this->createUser();
        $repository->updateToken($createdUser);
        $this->notSeeInDatabase('users', [
            'api_token' => $createdUser->apiToken()->token(),
        ]);
    }

    private function createUser(): UserAggregate
    {
        $userAggregate = UserAggregate::create(
            'email@email.com',
            'password',
            ApiToken::create(),
        );
        $userRepository = new MySqlUserRepository();
        $userRepository->save($userAggregate);
        return $userAggregate;
    }
}
