<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\User\Domain\ValueObjects;

use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class ApiToken
{
    private function __construct(
        private readonly string $token,
        private readonly DateTimeImmutable $expiration,
    ){
    }

    public static function create(
        string|null $token = null,
        DateTimeImmutable|null $expiration = null,
    ): self {
        if ($token === null) {
            $token = Uuid::uuid6()->toString();
        }
        if ($expiration === null) {
            $now = new DateTimeImmutable();
            $expiration = $now->add(new DateInterval('P1D'));
        }
        return new self (
            $token,
            $expiration,
        );
    }

    public function token(): string
    {
        return $this->token;
    }


    public function expiration(): DateTimeImmutable
    {
        return $this->expiration;
    }

    public static function hash($token): string
    {
        return hash('sha256', $token);
    }

    public static function check($token, $hash): bool
    {
        return hash('sha256', $token) === $hash;
    }

    public function showToUser(): string {
        return $this->token;
    }
}
