<?php

declare(strict_types=1);

namespace App\Contexts\Task\Application\UseCases;

use App\Contexts\Task\Domain\Interfaces\TaskRepositoryInterface;
use App\Contexts\Task\Domain\TaskAggregate;

class ListTasksUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
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
