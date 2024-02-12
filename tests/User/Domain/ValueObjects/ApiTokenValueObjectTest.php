<?php

declare(strict_types=1);

namespace Tests\User\Domain\ValueObjects;

use App\TaskManagementSystem\User\Domain\ValueObjects\ApiToken;
use Tests\UnitTestCase;

class ApiTokenValueObjectTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_hash(): void
    {
        $apiToken = ApiToken::create();
        $hash = ApiToken::hash($apiToken->token());
        $this->assertTrue(ApiToken::check($apiToken->token(), $hash));
    }
}
