<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Status\Domain\ValueObjects;

enum Description: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
