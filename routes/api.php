<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['api'])->group(function () {
    Route::get('/notes', [NotesController::class, 'index']);
    Route::post('/notes', [NotesController::class, 'store']);
    Route::get('/notes/{id}', [NotesController::class, 'show']);
    Route::put('/notes/{id}', [NotesController::class, 'updateText']);
    Route::delete('/notes/{id}', [NotesController::class, 'destroy']);
    Route::get('/notes/search/{title}', [NotesController::class, 'search']);
    Route::put('/notes/favorite/{id}', [NotesController::class, 'favorite']);
    Route::put('/notes/color/{id}', [NotesController::class, 'setColor']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
