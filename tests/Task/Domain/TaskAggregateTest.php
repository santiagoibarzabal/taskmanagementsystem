<?php

declare(strict_types=1);

namespace Tests\Task\Domain;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;
use Tests\UnitTestCase;

class UserAggregateTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;
    public function test_create_user_aggregate(): void
    {
        
    }
}
