<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return 'pong';
});


Route::apiResource('notes', NoteController::class);
