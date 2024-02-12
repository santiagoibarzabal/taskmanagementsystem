<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Application\UseCases;

use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;

class ListTasksUseCase
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
    ){
    }

    /**
     * @return array<TaskAggregate>
     */
    public function execute(): array
    {
        return $this->taskRepository->get();
    }
}
