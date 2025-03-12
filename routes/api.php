<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->controller(TaskController::class)->group(function() {
    Route::get('/task', 'index');
    Route::get('/task/{id}', 'show');
    Route::post('/task', 'store');
    Route::put('/task/{id}', 'update');
    Route::patch('/task/{id}', 'update');
    Route::delete('/task/{id}', 'destroy');
});

