<?php

declare(strict_types=1);

namespace Tests\Task\Infrastructure\Repositories;

use App\TaskManagementSystem\Status\Domain\StatusAggregate;
use App\TaskManagementSystem\Status\Domain\ValueObjects\Description;
use App\TaskManagementSystem\Status\Infrastructure\MySqlStatusRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\IntegrationTestCase;

class MySqlTaskRepositoryIntegrationTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    use DatabaseMigrations;
    public function test_save(): void
    {
        $statusAggregate = StatusAggregate::create(
            Description::PENDING
        );
        $statusRepository = new MySqlStatusRepository();
        $statusRepository->save($statusAggregate);
        $this->seeInDatabase('status', [
            'description' => 'pending',
        ]);
    }
}
