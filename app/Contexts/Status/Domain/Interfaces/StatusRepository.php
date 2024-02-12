<?php

declare(strict_types=1);

namespace App\Contexts\Status\Domain\Interfaces;

use App\Contexts\Status\Domain\StatusAggregate;

interface StatusRepository
{
    public function save(StatusAggregate $statusAggregate): void;
}
