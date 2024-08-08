<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;

Route::get('/test-connection', function () {
    return response()->json('Connection successful', 200);
});

Route::apiResource('notes', NoteController::class);
Route::post('notes/{note}/file', [NoteController::class, 'attachFile']);
Route::delete('notes/{note}/file', [NoteController::class, 'detachFile']);
