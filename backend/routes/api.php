<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PhotoController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckTokenForAnyScope;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);

    Route::post('/user/photo', [PhotoController::class, 'updatePhotoUser']);
});
