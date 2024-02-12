<?php

declare(strict_types=1);

namespace Tests\User\Infrastructure\ApiControllers;

use Database\Seeders\TasksSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class GetApiTokenControllerIntegrationTest extends IntegrationTestCase
{
    private TasksSeeder $tasksSeeder;

    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;

    public function test_get_api_token_controller(): void
    {
        $this->seedAndGetApiToken();
        $response = $this->json('POST', '/users', [
            'email' => 'email@test.com',
            'password' => 'password',
        ]);
        $data = $response->response->json();
        $this->assertArrayHasKey('token', $data);
        $this->assertIsString($data['token']);
        $this->assertResponseStatus(200);
    }
}
