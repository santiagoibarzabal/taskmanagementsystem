<?php

declare(strict_types=1);

namespace App\Contexts\Task\Application\UseCases;

use App\Contexts\Status\Domain\StatusAggregate;
use App\Contexts\Status\Domain\ValueObjects\Description as StatusDescription;
use App\Contexts\Task\Domain\TaskAggregate;
use App\Contexts\Task\Infrastructure\Repositories\MySqlTaskRepository;
use Exception;
use Ramsey\Uuid\Uuid;

class ChangeStatusUseCase
{
    public function __construct(
        private readonly MySqlTaskRepository $taskRepository,
    ){
    }

    /**
     * @throws Exception
     */
    public function execute(string $taskId, string $status): void
    {
        $taskId = Uuid::fromString($taskId);
        $task = $this->taskRepository->findById($taskId);
        $statusDescription = StatusDescription::tryFrom($status);
        $status = StatusAggregate::create($statusDescription);
        $updatedTask = TaskAggregate::create(
            $task->title(),
            $task->description(),
            $task->priority(),
            $status,
            $task->id(),
            null,
            $task->createdAt(),
        );
        $this->taskRepository->update($updatedTask);
    }
}
