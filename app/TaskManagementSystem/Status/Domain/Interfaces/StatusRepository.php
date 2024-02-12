<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Status\Domain\Interfaces;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;

interface StatusRepository
{
    public function save(StatusAggregate $statusAggregate): void;
}
