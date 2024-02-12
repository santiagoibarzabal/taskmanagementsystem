<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Domain\ValueObjects;

use Exception;

class Title
{
    private function __construct(
        private readonly string $title,
    ){
    }

    /**
     * @throws Exception
     */
    public static function create(string $title): self
    {
        if (strlen($title) > 100) {
            throw new Exception('invalid_title');
        }
        return new self($title);
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
