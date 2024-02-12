<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Contexts\Status\Domain\Interfaces\StatusRepository;
use App\Contexts\Status\Domain\StatusAggregate;
use App\Contexts\Status\Domain\ValueObjects\Description as StatusDescription;
use App\Contexts\Task\Domain\Interfaces\TaskRepositoryInterface;
use App\Contexts\Task\Domain\TaskAggregate;
use App\Contexts\Task\Domain\ValueObjects\Description;
use App\Contexts\Task\Domain\ValueObjects\Priority;
use App\Contexts\Task\Domain\ValueObjects\Title;
use Exception;
use Illuminate\Database\Seeder;

final class TasksSeeder extends Seeder
{
    public function __construct(
        private readonly StatusRepository $statusRepository,
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $statusDescriptions = StatusDescription::cases();
        $statusAggregates = [];
        foreach ($statusDescriptions as $statusDescription) {
            $statusAggregate = StatusAggregate::create(
                $statusDescription,
            );
            $statusAggregates[] = $statusAggregate;
            $this->statusRepository->save($statusAggregate);
        }
        $taskAggregate = TaskAggregate::create(
            Title::create('This is my first task'),
            Description::create('This is a task description and it is very useful to understand the task with the crystal clear explanations from the PO.'),
            Priority::LOW,
            $statusAggregates[0],
        );
        $this->taskRepository->save($taskAggregate);
    }
}