<?php

declare(strict_types=1);

namespace App\Contexts\Status\Infrastructure;

use App\Contexts\Status\Domain\StatusAggregate;
use App\Contexts\Status\Domain\Interfaces\StatusRepository;

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
