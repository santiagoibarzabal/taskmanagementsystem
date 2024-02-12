<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Infrastructure\Repositories;

use App\TaskManagementSystem\Task\Domain\Exceptions\MappingException;
use App\TaskManagementSystem\Task\Domain\Exceptions\TaskNotFoundException;
use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepository;
use App\TaskManagementSystem\Task\Domain\TaskAggregate;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\Mappers\TaskMapper;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\UuidInterface;

class MySqlTaskRepository implements TaskRepository
{
    public function __construct(
        private readonly TaskMapper $taskMapper,
    ){
    }

    /**
     * @return array<TaskAggregate>
     * @throws Exception
     */
    public function get(): array
    {
        $tasks = app('db')
            ->table('tasks')
            ->select('tasks.*')
            ->get();
        $tasksArray = [];
        foreach ($tasks as $task) {
            $latestTaskStatus = app('db')->table('status_task')
                ->where('task_id', $task->id)->orderBy('created_at', 'DESC')->first();
            $status = app('db')->table('status')->where('id', $latestTaskStatus->status_id)->first();
            $userId = app('db')->table('task_user')
                ->where('task_id', $task->id)->orderBy('created_at', 'DESC')->first('user_id');
            $tasksArray[] = $this->taskMapper->databaseToDomain($task, $status, $userId);
        }
        return $tasksArray;
    }

    /**
     * @throws TaskNotFoundException
     * @throws MappingException
     */
    public function findById(UuidInterface $id): TaskAggregate
    {
        $task = app('db')->table('tasks')
            ->where('tasks.id', $id)
            ->select('tasks.*')
            ->first();
        if ($task === null) {
            throw new TaskNotFoundException();
        }
        $latestTaskStatus = app('db')->table('status_task')
            ->where('task_id', $task->id)->orderBy('created_at',  'DESC')->first();
        $status = app('db')->table('status')->where('id', $latestTaskStatus->status_id)->first();
        $userId = app('db')->table('task_user')
            ->where('task_id', $task->id)->orderBy('created_at', 'DESC')->first('user_id');

        return $this->taskMapper->databaseToDomain($task, $status, $userId);
    }

    public function save(TaskAggregate $taskAggregate): void
    {
        $now = new DateTimeImmutable();
        $db = app('db');
        $statusExists = $db->table('status')
            ->where('description', $taskAggregate->status()->description()->value)
            ->exists();
        if (!$statusExists) {
            $db->table('status')->insert([
                'id' => $taskAggregate->status()->id()->toString(),
                'description' => $taskAggregate->status()->description()->value,
                'created_at' => $taskAggregate->status()->createdAt()->format('Y-m-d H:i:s'),
                'updated_at' => $taskAggregate->status()->updatedAt()->format('Y-m-d H:i:s'),
            ]);
        }
        $statusId = $db->table('status')
            ->where('description', $taskAggregate->status()->description()->value)
            ->first()
            ->id;

        $db->table('tasks')->insert($this->taskMapper->domainToDatabase($taskAggregate));
        $db->table('status_task')->insert([
            'status_id' => $statusId,
            'task_id' => $taskAggregate->id()->toString(),
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);
        $db->table('task_user')->insert([
            'user_id' => $taskAggregate->userId()?->toString(),
            'task_id' => $taskAggregate->id()->toString(),
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @throws MappingException
     * @throws TaskNotFoundException
     */
    public function delete(UuidInterface $id): void
    {
        $db = app('db');
        $task = $this->findById($id);
        $db->table('task_user')
            ->where('user_id', $task->userId()?->toString())
            ->where('task_id', $task->id()->toString())
            ->delete();
        $db->table('status_task')
            ->where('status_id', $task->status()->id()->toString())
            ->where('task_id', $task->id()->toString())
            ->delete();
        $db->table('tasks')->where('tasks.id', $task->id()->toString())->delete();
    }

    public function update(TaskAggregate $taskAggregate): void
    {
        $now = new DateTimeImmutable();
        $db = app('db');
        $statusId = $this->getStatusIdFromAggregate($taskAggregate);
        $db->table('tasks')
            ->where('id', $taskAggregate->id()->toString())
            ->update([
                'title' => (string) $taskAggregate->title(),
                'description' => (string) $taskAggregate->description(),
                'priority' => $taskAggregate->priority()->value,
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ]);
        $db->table('status_task')->insert([
            'status_id' => $statusId,
            'task_id' => $taskAggregate->id()->toString(),
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);
        $db->table('task_user')->insert([
            'user_id' => $taskAggregate->userId()?->toString(),
            'task_id' => $taskAggregate->id()->toString(),
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    private function getStatusIdFromAggregate(TaskAggregate $taskAggregate): string
    {
        $now = new DateTimeImmutable();
        $db = app('db');
        $statusExists = $db->table('status')
            ->where('description', $taskAggregate->status()->description()->value)
            ->exists();
        if (!$statusExists) {
            $db->table('status')->insert([
                'id' => $taskAggregate->status()->id()->toString(),
                'description' => $taskAggregate->status()->description()->value,
                'created_at' => $now->format('Y-m-d H:i:s'),
                'updated_at' => $now->format('Y-m-d H:i:s'),
            ]);
        }
        return $db->table('status')
            ->where('description', $taskAggregate->status()->description()->value)
            ->first()
            ->id;
    }
}
