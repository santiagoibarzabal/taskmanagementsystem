<?php

declare(strict_types=1);

namespace App\Contexts\Status\Domain;

use App\Contexts\Status\Domain\ValueObjects\Description;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class StatusAggregate
{
    private function __construct(
        private readonly UuidInterface $id,
        private readonly Description $description,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt,
    ) {
    }

    public static function create(
        Description $description,
        DateTimeImmutable|null $createdAt = null,
        DateTimeImmutable|null $updatedAt = null,
        UuidInterface|null $id = null,
    ): self {
        if ($id === null) {
            $id = Uuid::uuid6();
        }
        $now = new DateTimeImmutable();
        if ($createdAt === null) {
            $createdAt = $now;
        }
        if ($updatedAt === null) {
            $updatedAt = $now;
        }
        return new self(
            $id,
            $description,
            $createdAt,
            $updatedAt,
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'description' => $this->description->value,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
