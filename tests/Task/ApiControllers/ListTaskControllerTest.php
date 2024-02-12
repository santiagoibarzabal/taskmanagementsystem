<?php

declare(strict_types=1);

namespace Tests\Task\ApiControllers;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutMiddleware;
use Tests\TestCase;

class ListTaskControllerTest extends TestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
        $this->tasksSeeder = app(TasksSeeder::class);
    }

    use WithoutMiddleware;
    use DatabaseMigrations;
    public function test_list_tasks_controller(): void
    {
        $this->get('/tasks');;
        $this->assertResponseOk();
    }
}
