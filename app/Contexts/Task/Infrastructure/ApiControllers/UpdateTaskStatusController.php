<?php

declare(strict_types=1);

namespace App\Contexts\Task\Infrastructure\ApiControllers;

use App\Contexts\Task\Application\Dto\StoreTaskDto;
use App\Contexts\Task\Application\UseCases\ChangeStatusUseCase;
use App\Contexts\Task\Application\UseCases\StoreTaskUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTaskStatusController
{
    public function __construct(
       private readonly ChangeStatusUseCase $changeStatusUseCase,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, $id): JsonResponse
    {
        $status = $request->input('status');
        $this->changeStatusUseCase->execute($id, $status);
        return response()->json([
            'status' => 200,
            'message' => 'Task status updated',
        ]);
    }
}
