<?php

declare(strict_types=1);

namespace Tests\Task\Infrastructure\ApiControllers;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class DeleteTaskControllerIntegrationTest extends IntegrationTestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;
    public function test_delete_task_controller(): void
    {
        $apiToken = $this->seedAndGetApiToken();
        $task = app('db')->table('tasks')->first();
        $uri = sprintf('/tasks/%s', $task->id);
        $this->json('DELETE', $uri, ['api_token' => $apiToken]);
        $this->assertResponseStatus(204);
    }
}
