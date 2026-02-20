<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function successResponse($data, string $message, int $statusCode = 200, bool $success = true): JsonResponse
    {

        return response()->json(compact('success', 'data', 'message'), $statusCode);

    }

    protected function errorResponse(string $message, int $statusCode = 400, bool $success = false): JsonResponse
    {

        return response()->json(compact('success', 'message', 'statusCode'), $statusCode);

    }
}
