<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\Api\v1\AuthController;
use  App\Http\Controllers\Api\v1\UserController;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'create']);
        Route::get('list', [UserController::class, 'getList']);
        Route::post('delete', [UserController::class, 'delete']);
    });
});
