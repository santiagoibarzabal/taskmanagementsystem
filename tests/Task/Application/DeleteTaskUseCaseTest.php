<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Task\Application\UseCases\AssignToUserUseCase;
use App\TaskManagementSystem\Task\Application\UseCases\DeleteUseCase;
use App\TaskManagementSystem\Task\Application\UseCases\ListTasksUseCase;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\UnitTestCase;

class DeleteUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_delete_use_case(): void
    {
        $taskId = Uuid::uuid6()->toString();
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $mockTaskRepository->shouldReceive('delete')->once()->andReturnNull();
        $useCase = new DeleteUseCase($mockTaskRepository);
        $useCase->execute($taskId);
    }
}
