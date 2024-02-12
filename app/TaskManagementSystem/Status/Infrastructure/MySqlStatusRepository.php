<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Status\Infrastructure;

use App\TaskManagementSystem\Status\Domain\Interfaces\StatusRepository;
use App\TaskManagementSystem\Status\Domain\StatusAggregate;

class MySqlStatusRepository implements StatusRepository
{
    public function save(StatusAggregate $statusAggregate): void
    {
        app('db')->table('status')->insert([
            'id' => $statusAggregate->id()->toString(),
            'description' => $statusAggregate->description()->value,
            'created_at' => $statusAggregate->createdAt(),
            'updated_at' => $statusAggregate->updatedAt(),
        ]);
    }
}
