<?php

declare(strict_types=1);

namespace App\Contexts\User\Application;

use App\Contexts\User\Domain\UserAggregate;
use App\Contexts\User\Domain\UserNotFoundException;
use App\Contexts\User\Domain\ValueObjects\ApiToken;
use App\Contexts\User\Infrastructure\Repositories\MySqlUserRepository;

final class GenerateApiTokenUseCase
{
    public function __construct(
        private readonly MySqlUserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(string $email, string $password): string
    {
        $user = $this->userRepository->findByEmailAndPassword($email, $password);
        $apiToken = ApiToken::create();
        $token = $apiToken->showToUser();
        $userAggregate = UserAggregate::create(
            $user->email(),
            $user->password(),
            $apiToken,
            $user->createdAt(),
            null,
            $user->id(),
        );
        $this->userRepository->updateToken($userAggregate);
        return $token;
    }
}
