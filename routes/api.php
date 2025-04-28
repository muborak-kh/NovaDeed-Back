<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'builder'], function() {
    Route::group(['prefix' => 'projects'], function() {
        Route::post('/list', [App\Http\Controllers\ProjectsController::class, 'list']);
        Route::post('/store', [App\Http\Controllers\ProjectsController::class, 'store']);
        Route::post('/deals', [\App\Http\Controllers\ProjectsController::class, 'deals']);
        Route::post('/confirm', [\App\Http\Controllers\ProjectsController::class, 'confirm']);
        Route::post('/close', [\App\Http\Controllers\ProjectsController::class, 'close']);
    });

    Route::group(['prefix' => 'flats'], function() {
        Route::post('/store', [App\Http\Controllers\FlatsController::class, 'store']);
    });
});


Route::group(['prefix' => 'customer'], function() {
    Route::group(['prefix' => 'projects'], function() {
        Route::post('/list', [\App\Http\Controllers\Customer\ProjectsController::class, 'list']);
        Route::post('/submit', [\App\Http\Controllers\Customer\ProjectsController::class, 'submit']);
        Route::post('/load-projects-to-pay', [\App\Http\Controllers\Customer\ProjectsController::class, 'loadProjectsToPay']);
        Route::post('/confirm-close', [\App\Http\Controllers\Customer\ProjectsController::class, 'confirmClose']);
    });
});
