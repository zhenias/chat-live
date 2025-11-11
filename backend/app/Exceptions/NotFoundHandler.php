<?php

namespace App\Exceptions;

use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotFoundHandler extends Exception
{
    public static function handle(NotFoundException $e, Request $request): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'code'    => $e->getCode() ?: 404,
        ], $e->getCode() ?: 404);
    }
}
