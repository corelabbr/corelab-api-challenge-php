<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;

Route::get('/test-connection', function () {
    return response()->json('Connection successful', 200);
});

Route::apiResource('/notes', NoteController::class);
Route::patch('/notes/{note}/favorite', [NoteController::class, 'toggleFavorite']);
