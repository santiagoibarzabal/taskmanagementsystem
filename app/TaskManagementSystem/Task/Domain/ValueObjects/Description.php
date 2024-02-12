<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Domain\ValueObjects;

use App\TaskManagementSystem\Task\Domain\Exceptions\InvalidTaskDescriptionException;

class Description
{
    private function __construct(
        private readonly string $description,
    ){
    }

    /**
     * @throws InvalidTaskDescriptionException
     */
    public static function create(string $description): self
    {
        if (strlen($description) > 240) {
            throw new InvalidTaskDescriptionException('invalid_description');
        }
        return new self($description);
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
