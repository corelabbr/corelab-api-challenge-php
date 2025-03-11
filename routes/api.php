<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'update']); 
Route::patch('/tasks/{id}/color', [TaskController::class, 'updateColor']); 
Route::patch('/tasks/{id}/favorite', [TaskController::class, 'updateFavorite']); 
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
