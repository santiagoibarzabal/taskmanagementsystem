<?php

declare(strict_types=1);

namespace App\Contexts\Task\Domain\ValueObjects;

use Exception;

class Description
{
    private function __construct(
        private readonly string $description,
    ){
    }

    /**
     * @throws Exception
     */
    public static function create(string $description): self
    {
        if (strlen($description) > 240) {
            throw new Exception('invalid_description');
        }
        return new self($description);
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
