<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Angular Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes intended for web
| clients.
| nevertheless, these routes my be used at some point by android client.
|
*/

Route::middleware(['jwt.auth'])->group(function() {

    Route::middleware(['user:is,"master"'])->group(function() {

        Route::apiResource('center', App\Http\Controllers\CenterController::class);
        
        Route::apiResource('vaccine', App\Http\Controllers\VaccineController::class);
        
        Route::apiResource('manager', App\Http\Controllers\ManagerController::class);
        
    });

    Route::middleware(['user:is,"manager"'])->group(function() {

        Route::apiResource('vaccinator', App\Http\Controllers\VaccinatorController::class);
        
        Route::apiResource('receptionist', App\Http\Controllers\ReceptionistController::class);
        
    });

});
