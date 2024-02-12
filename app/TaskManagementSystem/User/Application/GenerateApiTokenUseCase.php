<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\User\Application;

use App\TaskManagementSystem\User\Domain\Interfaces\UserRepository;
use App\TaskManagementSystem\User\Domain\UserAggregate;
use App\TaskManagementSystem\User\Domain\UserNotFoundException;
use App\TaskManagementSystem\User\Domain\ValueObjects\ApiToken;

class GenerateApiTokenUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository,
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
