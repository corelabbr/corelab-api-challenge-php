<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group(base_path('routes/api/v1/user.php'));
Route::prefix('/notes')->group(base_path('routes/api/v1/note.php'));

