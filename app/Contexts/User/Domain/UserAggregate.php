<?php

declare(strict_types=1);

namespace App\Contexts\User\Domain;

use App\Contexts\User\Domain\ValueObjects\ApiToken;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserAggregate
{
    private function __construct(
       private readonly UuidInterface $id,
       private readonly string $email,
       private readonly string $password,
       private readonly DateTimeImmutable $createdAt,
       private readonly DateTimeImmutable $updatedAt,
       private readonly ApiToken|null $apiToken = null,
    ) {
    }

    public static function create(
        string $email,
        string $password,
        ApiToken|null $apiToken = null,
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
            $email,
            $password,
            $createdAt,
            $updatedAt,
            $apiToken,
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function apiToken(): ApiToken|null
    {
        return $this->apiToken;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
