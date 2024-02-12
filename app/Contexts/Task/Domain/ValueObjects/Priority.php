<?php

declare(strict_types=1);

namespace App\Contexts\Task\Domain\ValueObjects;

enum Priority: string
{
    case URGENT = '3';
    case NORMAL = '2';
    case LOW = '1';
}
