<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatMessageController;
use App\Http\Controllers\Chat\ChatUserController;
use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'error' => 'Bad request.',
        'code'  => 400,
    ]);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);

    Route::post('/user/photo', [PhotoController::class, 'updatePhotoUser']);

    Route::get('/users', [UserController::class, 'getCollection']);
    Route::post('/users', [UserController::class, 'getCollectionSearch']);


    Route::prefix('/chats')->group(function () {
        Route::get('/', [ChatController::class, 'get']);
        Route::post('/', [ChatController::class, 'create']);
        Route::delete('/{chatId}', [ChatController::class, 'delete'])->whereNumber('chatId');

        Route::get('/{chatId}/messages', [ChatMessageController::class, 'get'])->whereNumber('chatId');
        Route::post('/{chatId}/messages', [ChatMessageController::class, 'create'])->whereNumber('chatId');
        Route::delete('/{chatId}/messages/{messageId}', [ChatMessageController::class, 'delete'])->whereNumber(['chatId', 'messageId']);

        Route::get('/{chatId}/participants', [ChatUserController::class, 'get'])->whereNumber('chatId');
        Route::post('/{chatId}/participants', [ChatUserController::class, 'create'])->whereNumber('chatId');
    });
});
