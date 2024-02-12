<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Task\Application\UseCases\ListTasksUseCase;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use Mockery;
use Tests\UnitTestCase;

class ListTasksUseCaseTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_list_tasks_use_case(): void
    {
        $mockTaskRepository = Mockery::mock(TaskRepository::class);
        $mockTaskAggregate = Mockery::mock(TaskAggregate::class);
        $mockTaskRepository->shouldReceive('get')->once()->andReturn([$mockTaskAggregate]);
        $useCase = new ListTasksUseCase($mockTaskRepository);
        $this->assertEquals($useCase->execute(), [$mockTaskAggregate]);
    }
}
