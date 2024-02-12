<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\TaskManagementSystem\User\Domain\Interfaces\UserRepository;
use App\TaskManagementSystem\User\Domain\UserAggregate;
use App\TaskManagementSystem\User\Domain\ValueObjects\ApiToken;
use Illuminate\Database\Seeder;

final class UsersSeeder extends Seeder
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function run()
    {
        $user = UserAggregate::create(
            'email@test.com',
            'password',
            ApiToken::create(),
        );
        $this->userRepository->save($user);
    }
}
