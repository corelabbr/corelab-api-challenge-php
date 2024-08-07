<?php

use App\Http\Controllers\api\TodosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/todos', [TodosController::class, 'index']);
Route::get('/todos/favorites', [TodosController::class, 'getFavorites']);
Route::get('/todos/others', [TodosController::class, 'getOthersTodos']);
Route::post('/todos/create', [TodosController::class, 'store']);
Route::patch('/todos/{todo}/update', [TodosController::class, 'update']);
Route::delete('/todos/{todo}/delete', [TodosController::class, 'delete']);
