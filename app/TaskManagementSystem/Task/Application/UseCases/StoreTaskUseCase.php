<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Application\UseCases;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Application\Dto\StoreTaskDto;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepositoryInterface;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use Exception;

class StoreTaskUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ){
    }

    /**
     * @throws Exception
     */
    public function execute(StoreTaskDto $storeTaskDto): void
    {
        $statusAggregate = StatusAggregate::create(StatusDescription::PENDING);
        $description = Description::create($storeTaskDto->description());
        $priority = Priority::tryFrom($storeTaskDto->priority());
        if ($priority === null) {
            throw new Exception('invalid_priority');
        }
        $taskAggregate = TaskAggregate::create(
            Title::create($storeTaskDto->title()),
            $description,
            $priority,
            $statusAggregate,
        );
        $this->taskRepository->save($taskAggregate);
    }
}
