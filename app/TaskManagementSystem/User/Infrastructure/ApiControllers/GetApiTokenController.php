<?php

declare(strict_types=1);

namespace App\TaskManagementSystem\User\Infrastructure\ApiControllers;


use App\TaskManagementSystem\User\Application\GenerateApiTokenUseCase;
use App\TaskManagementSystem\User\Domain\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetApiTokenController
{
    public function __construct(
        private readonly GenerateApiTokenUseCase $generateApiTokenUseCase,
    ){
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $token = $this->generateApiTokenUseCase->execute($email, $password);
        return response()->json([
            'status' => 200,
            'token' => $token,
        ]);
    }
}
