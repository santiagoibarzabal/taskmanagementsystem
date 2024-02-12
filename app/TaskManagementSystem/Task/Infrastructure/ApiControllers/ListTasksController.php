<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\Task\Infrastructure\ApiControllers;

use App\TaskManagementSystem\Task\Application\UseCases\ListTasksUseCase;
use Exception;
use Illuminate\Http\JsonResponse;

class ListTasksController
{
    public function __construct(
        private readonly ListTasksUseCase $listTasksUseCase,
    ){
    }
    public function __invoke(): JsonResponse
    {
        try {
            $tasks = $this->listTasksUseCase->execute();
        } catch (Exception $e) {
            app('log')->info($e->getMessage());
            $response = [
                'message' => 'Bad Request',
                'status' => 400,
            ];
            return response()->json($response, 400);
        }

        $data = [];
        foreach ($tasks as $task) {
            $data[] = $task->toArray();
        }
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }
}
