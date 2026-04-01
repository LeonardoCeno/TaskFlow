<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::get('{id}', [ProjectController::class, 'show']);
    Route::put('{id}', [ProjectController::class, 'update']);
    Route::delete('{id}', [ProjectController::class, 'destroy']);

    Route::prefix('{id}/tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('{taskId}', [TaskController::class, 'show']);
        Route::put('{taskId}', [TaskController::class, 'update']);
        Route::delete('{taskId}', [TaskController::class, 'destroy']);
        Route::patch('{taskId}/status', [TaskController::class, 'updateStatus']);
    });
});

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
});

Route::prefix('tasks/{taskId}/tags')->group(function () {
    Route::post('{tagId}', [TagController::class, 'attachTag']);
    Route::delete('{tagId}', [TagController::class, 'detachTag']);
});

Route::prefix('users/{id}/profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::put('/', [ProfileController::class, 'update']);
});