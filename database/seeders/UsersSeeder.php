<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Contexts\User\Domain\UserAggregate;
use App\Contexts\User\Domain\ValueObjects\ApiToken;
use App\Contexts\User\Infrastructure\Repositories\MySqlUserRepository;
use Illuminate\Database\Seeder;

final class UsersSeeder extends Seeder
{
    public function __construct(
        private readonly MySqlUserRepository $userRepository,
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
