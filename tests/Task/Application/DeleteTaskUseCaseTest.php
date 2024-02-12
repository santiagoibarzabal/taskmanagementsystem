<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Task\Application\UseCases\DeleteTaskUseCase;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\UnitTestCase;

class DeleteTaskUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_delete_task_use_case(): void
    {
        $taskId = Uuid::uuid6()->toString();
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $mockTaskRepository->shouldReceive('delete')->once()->andReturnNull();
        $useCase = new DeleteTaskUseCase($mockTaskRepository);
        $useCase->execute($taskId);
    }
}
