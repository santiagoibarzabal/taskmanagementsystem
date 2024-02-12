<?php

declare(strict_types=1);

namespace App\Contexts\Task\Application\UseCases;

use App\Contexts\Task\Domain\Interfaces\TaskRepositoryInterface;
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
