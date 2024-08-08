<?php

use App\Http\Controllers\api\TodosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('todos')->group(function () {
    Route::get('/', [TodosController::class, 'index']);
    Route::get('/favorites', [TodosController::class, 'getFavorites']);
    Route::get('/others', [TodosController::class, 'getOthersTodos']);
    Route::post('/create', [TodosController::class, 'store']);
    Route::patch('/{todo}/update', [TodosController::class, 'update']);
    Route::patch('/{todo}/update/color', [TodosController::class, 'setTodoColor']);
    Route::patch('/{todo}/update/favorite', [TodosController::class, 'favoriteTodo']);
    Route::delete('/{todo}/delete', [TodosController::class, 'delete']);
});
