<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Application\Dto;

final class StoreTaskDto
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly string $priority,
    ){
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function priority(): string
    {
        return $this->priority;
    }
}
