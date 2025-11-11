<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExistsResourceHandler extends Exception
{
    public static function handle(BadRequestHttpException $e, Request $request): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'code'    => $e->getCode() ?: 400,
        ], $e->getCode() ?: 400);
    }
}
