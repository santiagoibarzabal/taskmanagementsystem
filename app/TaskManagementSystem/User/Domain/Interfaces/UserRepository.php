<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\User\Domain\Interfaces;

use App\TaskManagementSystem\User\Domain\UserAggregate;
use Exception;

interface UserRepository
{
    /**
     * @throws Exception
     */
    public function find(string $apiToken): UserAggregate;
    public function findByEmailAndPassword(string $email, string $password): UserAggregate;
    public function save(UserAggregate $userAggregate): void;
    public function updateToken(UserAggregate $userAggregate): void;
}
