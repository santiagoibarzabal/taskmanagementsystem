<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\TaskManagementSystem\Status\Domain\Interfaces\StatusRepository;
use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description as StatusDescription;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use Exception;
use Illuminate\Database\Seeder;

final class TasksSeeder extends Seeder
{
    public function __construct(
        private readonly StatusRepository $statusRepository,
        private readonly TaskRepository $taskRepository,
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
            Description::create('This is a task description and it is very useful to understand the task.'),
            Priority::LOW,
            $statusAggregates[0],
        );
        $this->taskRepository->save($taskAggregate);
    }
}
