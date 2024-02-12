<?php

declare(strict_types=1);

namespace Tests\User\Infrastructure\ApiControllers;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class GetApiControllerIntegrationTest extends IntegrationTestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;

    public function test_store_task_controller(): void
    {
        $apiToken = $this->seedAndGetApiToken();
        $this->json('POST', '/tasks', [
            'description' => 'description',
            'title' => 'title',
            'priority' => '1',
            'api_token' => $apiToken,
        ]);
        $this->assertResponseStatus(201);
    }
}
