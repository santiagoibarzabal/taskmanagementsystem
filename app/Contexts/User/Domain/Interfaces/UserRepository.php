<?php

declare(strict_types=1);

namespace App\Contexts\User\Domain\Interfaces;

use App\Contexts\User\Domain\UserAggregate;
use Exception;

interface UserRepository
{
    /**
     * @throws Exception
     */
    public function find(string $apiToken): UserAggregate;
    public function save(UserAggregate $userAggregate): void;
}
