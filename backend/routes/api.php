<?php

use App\Http\Controllers\User\PhotoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);

    Route::post('/user/photo', [PhotoController::class, 'updatePhotoUser']);
});
