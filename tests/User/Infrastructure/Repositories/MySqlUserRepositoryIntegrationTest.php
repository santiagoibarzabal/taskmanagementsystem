<?php

declare(strict_types=1);

namespace Tests\User\Infrastructure\Repositories;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\Mappers\TaskMapper;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\MySqlTaskRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class MySqlUserRepositoryIntegrationTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;

    public function test_save(): void
    {
        $taskAggregate = $this->saveTask();
        $mapper = new TaskMapper();
        $this->seeInDatabase('tasks', $mapper->domainToDatabase($taskAggregate));
    }

    public function test_get(): void
    {
        $this->seedAndGetApiToken();
        $mapper = new TaskMapper();
        $taskRepository = new MySqlTaskRepository($mapper);
        $tasks = $taskRepository->get();
        foreach ($tasks as $task) {
            $this->assertInstanceOf(TaskAggregate::class, $task);
        }
    }

    public function test_find_by_id(): void
    {
        $taskAggregate = $this->saveTask();
        $mapper = new TaskMapper();
        $taskRepository = new MySqlTaskRepository($mapper);
        $task = $taskRepository->findById($taskAggregate->id());
        $this->assertInstanceOf(TaskAggregate::class, $task);
    }

    public function test_delete(): void
    {
        $taskAggregate = $this->saveTask();
        $mapper = new TaskMapper();
        $taskRepository = new MySqlTaskRepository($mapper);
        $taskRepository->delete($taskAggregate->id());
        $this->notSeeInDatabase('tasks', [
            'id' => $taskAggregate->id()->toString()
        ]);
    }

    public function test_update(): void
    {
        $taskAggregate = $this->saveTask();
        $mapper = new TaskMapper();
        $taskRepository = new MySqlTaskRepository($mapper);
        $updatedTask = TaskAggregate::create(
            $taskAggregate->title(),
            $taskAggregate->description(),
            Priority::URGENT,
            $taskAggregate->status(),
            $taskAggregate->id(),
            $taskAggregate->userId(),
            $taskAggregate->createdAt(),
        );
        $taskRepository->update($updatedTask);
        $this->seeInDatabase('tasks', [
            'id' => $updatedTask->id()->toString(),
            'priority' => $updatedTask->priority()->value,
        ]);
    }

    private function saveTask(): TaskAggregate
    {
        $taskAggregate = TaskAggregate::create(
            Title::create('title'),
            Description::create('description'),
            Priority::LOW,
            StatusAggregate::create(StatusDescription::PENDING)
        );
        $mapper = new TaskMapper();
        $taskRepository = new MySqlTaskRepository($mapper);
        $taskRepository->save($taskAggregate);
        return $taskAggregate;
    }
}
