<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Domain\ValueObjects;

use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskTitleException;

class Title
{
    private function __construct(
        private readonly string $title,
    ){
    }

    /**
     * @throws InvalidTaskTitleException
     */
    public static function create(string $title): self
    {
        if (strlen($title) > 100) {
            throw new InvalidTaskTitleException('invalid_title');
        }
        return new self($title);
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
