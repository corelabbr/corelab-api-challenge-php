<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{NoteController,FileController};

Route::get('/test-connection', function () {
    return response()->json('Connection successful', 200);
});

Route::apiResources([
    'notes' => NoteController::class,
    'files' => FileController::class,
]);
