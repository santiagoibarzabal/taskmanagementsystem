<?php

declare(strict_types=1);

namespace App\Contexts\Task\Infrastructure\ApiControllers;

use App\Contexts\Task\Application\Dto\StoreTaskDto;
use App\Contexts\Task\Application\UseCases\StoreTaskUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreTaskController
{
    public function __construct(
       private readonly StoreTaskUseCase $storeTaskUseCase,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validate = is_string($request->input('title'))
            && is_string($request->input('description'))
            && is_string($request->input('priority'));
        if (!$validate) {
            return response()->json([
                'status' => '400',
                'message' => 'Bad Request - Invalid parameters',
            ]);
        }
        $dto = new StoreTaskDto(
            $request->input('title'),
            $request->input('description'),
            $request->input('priority'),
        );
        $this->storeTaskUseCase->execute($dto);
        return response()->json([
            'status' => 200,
            'message' => 'Task stored',
        ]);
    }
}
