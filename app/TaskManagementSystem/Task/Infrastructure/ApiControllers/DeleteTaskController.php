<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Infrastructure\ApiControllers;


use App\TaskManagementSystem\Task\Application\UseCases\DeleteUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class DeleteTaskController
{
    public function __construct(
       private readonly DeleteUseCase $deleteUseCase,
    ) {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            $response = [
                'error' => 'The id provided is invalid. Please provide a valid UUID',
                'status' => '400 - Bad Request',
            ];
            return response()->json($response, 400);
        }
        try {
            $this->deleteUseCase->execute($id);
        } catch (Exception $e) {
            $response = [
                'error' => $e->getMessage(),
                'status' => '400 - Bad Request',
            ];
            return response()->json($response, 400);
        }
        return response()->json([], 204);
    }
}
