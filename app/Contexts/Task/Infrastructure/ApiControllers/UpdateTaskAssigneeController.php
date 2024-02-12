<?php

declare(strict_types=1);

namespace App\Contexts\Task\Infrastructure\ApiControllers;

use App\Contexts\Task\Application\Dto\StoreTaskDto;
use App\Contexts\Task\Application\UseCases\AssignToUserUseCase;
use App\Contexts\Task\Application\UseCases\StoreTaskUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTaskAssigneeController
{
    public function __construct(
       private readonly AssignToUserUseCase $assignToUserUseCase,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $userId = $request->input('user_id');
        $this->assignToUserUseCase->execute($id, $userId);
        return response()->json([
            'status' => 200,
            'message' => 'Task assigned to user',
        ]);
    }
}
