<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::put('/items/{id}', [ItemController::class, 'update']);
Route::put('/item-favorite/{id}', [ItemController::class, 'updateFavorite']);
Route::put('/item-color/{id}', [ItemController::class, 'updateColor']);
Route::delete('/items/{id}', [ItemController::class, 'destroy']);