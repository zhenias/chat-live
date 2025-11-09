<?php

use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Chat\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);

    Route::post('/user/photo', [PhotoController::class, 'updatePhotoUser']);


    Route::prefix('/chats')->group(function () {
        Route::get('/', [ChatController::class, 'get']);
        Route::post('/', [ChatController::class, 'create']);
        Route::delete('/{chatId}', [ChatController::class, 'delete']);


    });
});
