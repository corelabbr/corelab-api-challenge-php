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

Route::apiResource('users', 'App\Http\Controllers\UsersController');
Route::apiResource('/tasks', 'App\Http\Controllers\TasksController');
Route::apiResource('categorias', 'App\Http\Controllers\CategoriasController');
