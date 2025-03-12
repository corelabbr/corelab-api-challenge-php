<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('', [UserController::class, 'store']);
Route::post('/validate', [UserController::class, 'validate']);
Route::middleware('jwt.auth')->get('', [UserController::class, 'read']);
Route::middleware('jwt.auth')->delete('/delete', [UserController::class, 'delete']);
Route::middleware('jwt.auth')->put('/update', [UserController::class, 'update']);
Route::middleware('jwt.auth')->get('/logout', [UserController::class, 'logout']);