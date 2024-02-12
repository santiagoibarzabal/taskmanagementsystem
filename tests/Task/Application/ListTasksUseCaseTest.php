<?php

declare(strict_types=1);

namespace Tests\Task\Application;

use App\TaskManagementSystem\Task\Application\UseCases\AssignToUserUseCase;
use App\TaskManagementSystem\Task\Infrastructure\Repositories\MySqlTaskRepository;
use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class AssignToUserUseCaseTest extends IntegrationTestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;
    public function test_assign_to_user_use_case(): void
    {
        $useCase = app(AssignToUserUseCase::class);
        $useCase->execute();
    }
}
