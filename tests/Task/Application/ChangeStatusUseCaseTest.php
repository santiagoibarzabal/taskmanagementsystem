<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Status\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Application\UseCases\ChangeStatusUseCase;
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

    public function test_change_status_use_case(): void
    {
        $taskId = Uuid::uuid6()->toString();
        $status = Description::PENDING->value;
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $taskAggregate = Mockery::mock(TaskAggregate::class);
        $mockTaskRepository->shouldReceive('findById')->once()->andReturn($taskAggregate);
        $mockTaskRepository->shouldReceive('update')->once()->andReturnNull();
        $taskAggregate->shouldReceive('id')->once();
        $taskAggregate->shouldReceive('title')->once();
        $taskAggregate->shouldReceive('description')->once();
        $taskAggregate->shouldReceive('priority')->once()->andReturn(Priority::LOW);
        $taskAggregate->shouldReceive('createdAt')->once();
        $useCase = new ChangeStatusUseCase($mockTaskRepository);
        $useCase->execute($taskId, $status);
    }
}
