<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApiValidationHandler extends Exception
{
    public static function handle(ValidationException $e, Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid input data.',
            'errors' => $e->errors(),
        ], 422);
    }
}
