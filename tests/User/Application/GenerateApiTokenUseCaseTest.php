<?php

declare(strict_types=1);

namespace Tests\User\Application;

use App\TaskManagementSystem\User\Application\GenerateApiTokenUseCase;
use App\TaskManagementSystem\User\Domain\Interfaces\UserRepository;
use App\TaskManagementSystem\User\Domain\UserAggregate;
use Mockery;
use Tests\UnitTestCase;

class GenerateApiTokenUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_generate_api_token_use_case(): void
    {
        $email = 'email';
        $password = 'password';
        $mockUserRepository = Mockery::mock(UserRepository::class);
        $userAggregate = Mockery::mock(UserAggregate::class);
        $userAggregate->shouldReceive('email')->once();
        $userAggregate->shouldReceive('password')->once();
        $userAggregate->shouldReceive('createdAt')->once();
        $userAggregate->shouldReceive('id')->once();
        $mockUserRepository->shouldReceive('findByEmailAndPassword')->once()->andReturn($userAggregate);
        $mockUserRepository->shouldReceive('updateToken')->once()->andReturn();
        $useCase = new GenerateApiTokenUseCase($mockUserRepository);
        $result = $useCase->execute($email, $password);
        $this->assertIsString($result);
    }
}
