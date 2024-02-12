<?php

declare(strict_types=1);

namespace Tests\Task\Infrastructure\ApiControllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class ListTasksControllerIntegrationTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;
    public function test_list_tasks_controller(): void
    {
        $apiToken = $this->seedAndGetApiToken();
        $response = $this->json('GET', '/tasks', ['api_token' => $apiToken]);
        $data = $response->response->json()['data'];
        $keys = ['id', 'title', 'description', 'priority', 'status', 'userId', 'createdAt', 'updatedAt'];
        foreach ($data as $result) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $result);
            }
        }
        $this->assertResponseOk();
    }
}
