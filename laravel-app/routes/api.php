<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\CategoriasController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});
Route::post('/login', [('App\Http\Controllers\AuthController')::class, 'authenticate']);
Route::apiResource('users', 'App\Http\Controllers\UsersController');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', 'App\Http\Controllers\TasksController');
    Route::apiResource('categorias', 'App\Http\Controllers\CategoriasController');
});
