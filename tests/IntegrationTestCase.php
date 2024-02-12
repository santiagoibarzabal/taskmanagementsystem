<?php

namespace Tests;

use App\TaskManagementSystem\User\Application\GenerateApiTokenUseCase;
use Database\Seeders\TasksSeeder;
use Database\Seeders\UsersSeeder;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class IntegrationTestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function seedAndGetApiToken(): string
    {
        app(UsersSeeder::class)->run();
        app(TasksSeeder::class)->run();
        return app(GenerateApiTokenUseCase::class)
            ->execute('email@test.com', 'password');
    }
}
