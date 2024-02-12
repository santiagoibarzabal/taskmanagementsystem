<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Domain;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Priority;
use App\TaskManagementSystem\Task\Domain\ValueObjects\Title;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class TaskAggregate
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly Title $title,
        private readonly Description $description,
        private readonly Priority $priority,
        private readonly StatusAggregate $status,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt,
        private readonly UuidInterface|null $userId = null,
    ) {
    }

    public static function create(
        Title $title,
        Description $description,
        Priority $priority,
        StatusAggregate $status,
        UuidInterface|null $id = null,
        UuidInterface|null $userId = null,
        DateTimeImmutable|null $createdAt = null,
        DateTimeImmutable|null $updatedAt = null,
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
            $title,
            $description,
            $priority,
            $status,
            $createdAt,
            $updatedAt,
            $userId,
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function priority(): Priority
    {
        return $this->priority;
    }

    public function status(): StatusAggregate
    {
        return $this->status;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function userId(): UuidInterface|null
    {
        return $this->userId;
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'title' => (string) $this->title,
            'description' => (string) $this->description,
            'priority' => $this->priority->value,
            'status' => $this->status->toArray(),
            'userId' => $this->userId?->toString(),
            'createdAt' => $this->createdAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
