<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Application\Dto\StoreTaskDto;
use App\TaskManagementSystem\Task\Application\UseCases\AssignToUserUseCase;
use App\TaskManagementSystem\Task\Application\UseCases\StoreTaskUseCase;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use Mockery;
use Ramsey\Uuid\Uuid;
use Tests\UnitTestCase;

class StoreTaskUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_store_task_use_case(): void
    {
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $mockTaskRepository->shouldReceive('save')->once()->andReturnNull();
        $useCase = new StoreTaskUseCase($mockTaskRepository);
        $storeTaskDto = Mockery::mock(StoreTaskDto::class);
        $storeTaskDto->shouldReceive('title')->once();
        $storeTaskDto->shouldReceive('description')->once();
        $storeTaskDto->shouldReceive('priority')->once()->andReturn(Priority::LOW->value);
        $useCase->execute($storeTaskDto);
    }
}
