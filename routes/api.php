<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::prefix('todo')->group(function () {
        Route::get('/stats', [TodoItemController::class, 'stats']);
        Route::get('/', [TodoItemController::class, 'index']);
        Route::post('/', [TodoItemController::class, 'store']);
        Route::get('/{todo}', [TodoItemController::class, 'show']);
        Route::put('/{todo}', [TodoItemController::class, 'update']);
        Route::delete('/{todo}', [TodoItemController::class, 'destroy']);
    });
});
