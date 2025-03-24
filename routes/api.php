<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::apiResource(name:'tasks', controller: TaskController::class);
