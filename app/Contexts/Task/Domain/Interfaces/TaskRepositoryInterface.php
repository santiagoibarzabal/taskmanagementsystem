<?php

declare(strict_types=1);

namespace App\Contexts\Task\Domain\Interfaces;

use App\Contexts\Task\Domain\TaskAggregate;
use Ramsey\Uuid\UuidInterface;

interface TaskRepositoryInterface
{
    /**
     * @return array<TaskAggregate>
     */
    public function get(): array;
    public function findById(UuidInterface $id): TaskAggregate;
    public function save(TaskAggregate $taskAggregate): void;
    public function delete(UuidInterface $id): void;
}
