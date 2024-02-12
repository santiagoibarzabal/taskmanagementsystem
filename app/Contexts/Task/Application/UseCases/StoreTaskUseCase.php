<?php

declare(strict_types=1);

namespace App\Contexts\Task\Application\UseCases;

use App\Contexts\Status\Domain\StatusAggregate;
use App\Contexts\Task\Application\Dto\StoreTaskDto;
use App\Contexts\Task\Domain\Interfaces\TaskRepositoryInterface;
use App\Contexts\Task\Domain\TaskAggregate;
use App\Contexts\Task\Domain\ValueObjects\Description;
use App\Contexts\Task\Domain\ValueObjects\Priority;
use App\Contexts\Task\Domain\ValueObjects\Title;
use App\Contexts\Status\Domain\ValueObjects\Description as StatusDescription;
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
