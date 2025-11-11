<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatMessageController;
use App\Http\Controllers\Chat\ChatUserController;
use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);

    Route::post('/user/photo', [PhotoController::class, 'updatePhotoUser']);

    Route::get('/users', [UserController::class, 'getCollection']);

    Route::prefix('/chats')->group(function () {
        Route::get('/{chatId}/messages', [ChatMessageController::class, 'get']);
        Route::post('/{chatId}/messages', [ChatMessageController::class, 'create']);
        Route::delete('/{chatId}/messages/{messageId}', [ChatMessageController::class, 'delete']);

        Route::get('/{chatId}/participants', [ChatUserController::class, 'get']);

        Route::get('/', [ChatController::class, 'get']);
        Route::post('/', [ChatController::class, 'create']);
        Route::delete('/{chatId}', [ChatController::class, 'delete']);
    });
});
