<?php

use Illuminate\Support\Facades\Route;

// Defina suas rotas web aqui
Route::get('/', function () {
    return view('welcome');
});