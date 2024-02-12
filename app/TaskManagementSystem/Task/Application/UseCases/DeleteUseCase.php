<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Application\UseCases;

use App\TaskManagementSystem\Task\Domain\Interfaces\TaskRepositoryInterface;
use Exception;
use Ramsey\Uuid\Uuid;

class DeleteUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ){
    }

    /**
     * @throws Exception
     */
    public function execute(string $id): void
    {
        $id = Uuid::fromString($id);
        $this->taskRepository->delete($id);
    }
}
