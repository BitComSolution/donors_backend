<?php

use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\Api\v1\AuthController;
use  App\Http\Controllers\Api\v1\UserController;
use  App\Http\Controllers\Api\v1\ScheduledController;
use  App\Http\Controllers\Api\v1\LogsController;
use  App\Http\Controllers\Api\v1\SourceController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'create']);
        Route::get('list', [UserController::class, 'getList']);
        Route::put('edit/{user}', [UserController::class, 'edit']);
        Route::post('delete', [UserController::class, 'delete']);
    });
    Route::prefix('command')->group(function () {
        Route::get('get', [ScheduledController::class, 'get']);
        Route::put('edit/{scheduled}', [ScheduledController::class, 'edit']);
        Route::post('create', [ScheduledController::class, 'create']);
        Route::delete('delete/{scheduled}', [ScheduledController::class, 'delete']);
    });
    Route::prefix('logs')->group(function () {
        Route::get('list', [LogsController::class, 'getList']);
        Route::post('file/{id}', [LogsController::class, 'getFile']);
    });
    Route::prefix('source')->group(function () {
        Route::post('aist', [SourceController::class, 'aist']);
        Route::post('request', [SourceController::class, 'sendRequest']);
        Route::get('list', [SourceController::class, 'getListDonors']);
        Route::get('{source}', [SourceController::class, 'getItem']);
    });
});
Route::prefix('webhook')->group(function () {
    Route::get('aist', [SourceController::class, 'ready']);
});
