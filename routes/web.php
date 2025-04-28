<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BuildersController;

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/builder', [BuildersController::class, 'init']);
Route::get('/dev', [\App\Http\Controllers\DevController::class, 'main']);
