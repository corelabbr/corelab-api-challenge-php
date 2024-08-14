<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;

Route::apiResource('/tasks', TaskController::class)->middleware(Cors::class);
