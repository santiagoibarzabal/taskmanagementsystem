<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Application\UseCases;

use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\MySqlTaskRepository;
use Exception;
use Ramsey\Uuid\Uuid;

class AssignToUserUseCase
{
    public function __construct(
        private readonly MySqlTaskRepository $taskRepository,
    ){
    }

    /**
     * @throws Exception
     */
    public function execute(string $taskId, string $userId): void
    {
        $taskId = Uuid::fromString($taskId);
        $task = $this->taskRepository->findById($taskId);
        try {
            $userUuid = Uuid::fromString($userId);
        } catch (Exception) {
            throw new Exception('invalid_user_id');
        }
        $updatedTask = TaskAggregate::create(
            $task->title(),
            $task->description(),
            $task->priority(),
            $task->status(),
            $task->id(),
            $userUuid,
            $task->createdAt(),
        );
        $this->taskRepository->update($updatedTask);
    }
}
