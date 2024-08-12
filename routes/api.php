<?php

use App\Http\Controllers\api\TodosController;
use Illuminate\Support\Facades\Route;

Route::prefix('todos')->group(function () {
    Route::get('/', [TodosController::class, 'index']);
    Route::post('/create', [TodosController::class, 'store']);
    Route::patch('/{todo}/update', [TodosController::class, 'update']);
    Route::patch('/{todo}/update/color', [TodosController::class, 'setTodoColor']);
    Route::patch('/{todo}/update/favorite', [TodosController::class, 'favoriteTodo']);
    Route::delete('/{todo}/delete', [TodosController::class, 'delete']);
});
