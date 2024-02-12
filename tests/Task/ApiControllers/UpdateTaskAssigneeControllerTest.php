<?php

declare(strict_types=1);

namespace Tests\Task\ApiControllers;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutMiddleware;
use Tests\TestCase;

class UpdateTaskAssigneeControllerTest extends TestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
    }

    use WithoutMiddleware;
    use DatabaseMigrations;
    public function test_store_task_controller(): void
    {
        $this->post('/tasks', [
            'description' => 'description',
            'title' => 'title',
            'priority' => '1',
        ]);
        $this->assertResponseStatus(200);
    }
}
