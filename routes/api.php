<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rotas protegidas por autenticação
Route::middleware(['auth:sanctum'])->group(function () {
    // Rotas de autenticação
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Cores de tarefas
    Route::get('/tasks/colors', [TaskController::class, 'colors']);
    // Tarefas favoritas
    Route::get('/tasks/favorites', [TaskController::class, 'favorites']);
    // Rotas de tarefas
    Route::apiResource('tasks', TaskController::class);
    // Rotas de status da tarefa
    Route::get('/tasks/status/{status}', [TaskController::class, 'getByStatus']);
    // Atualizar cor da tarefa
    Route::put('/tasks/{id}/color/{colorId}', [TaskController::class, 'updateColor']);
    Route::post('/tasks/{id}/favorite', [TaskController::class, 'toggleFavorite']);
});
