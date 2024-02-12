<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Task\Application\UseCases\AssignToUserUseCase;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\UnitTestCase;

class ChangeStatusUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_assign_to_user_use_case(): void
    {
        $taskId = Uuid::uuid6()->toString();
        $userId = Uuid::uuid6()->toString();
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $taskAggregate = Mockery::mock(TaskAggregate::class);
        $mockTaskRepository->shouldReceive('findById')->once()->andReturn($taskAggregate);
        $mockTaskRepository->shouldReceive('update')->once()->andReturnNull();
        $taskAggregate->shouldReceive('id')->once();
        $taskAggregate->shouldReceive('title')->once();
        $taskAggregate->shouldReceive('description')->once();
        $taskAggregate->shouldReceive('priority')->once()->andReturn(Priority::LOW);
        $taskAggregate->shouldReceive('status')->once();
        $taskAggregate->shouldReceive('createdAt')->once();
        $useCase = new AssignToUserUseCase($mockTaskRepository);
        $useCase->execute($taskId, $userId);
    }
}
