<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;

Route::prefix('v1/user')->controller(UserController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});
    
Route::prefix('v1')->middleware('auth:sanctum')->controller(TaskController::class)->group(function() {
    Route::get('/task', 'index');
    Route::post('/task', 'store');
    Route::put('/task/{id}', 'update');
    Route::patch('/task/{id}', 'update');
    Route::delete('/task/{id}', 'destroy');
});

