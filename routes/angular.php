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
        
        Route::get('center-unmanaged', [App\Http\Controllers\UnmanagedCenterController::class, 'index']);

        Route::get('master-me', [App\Http\Controllers\MasterController::class, 'me']);
        
        Route::get('distribution-plan', [App\Http\Controllers\DistributionPlanController::class, 'show']);

        Route::get('center-doses/{center}', [App\Http\Controllers\CenterDoseController::class, 'show']);

        Route::post('center-doses', [App\Http\Controllers\CenterDoseController::class, 'store']);

        Route::get('day', [App\Http\Controllers\DayController::class, 'index']);

        Route::get('center/{center}/day', [App\Http\Controllers\DayController::class, 'show']);

        Route::post('center/{center}/day', [App\Http\Controllers\DayController::class, 'store']);

        Route::post('vaccination-plan', [App\Http\Controllers\VaccinationPlanController::class, 'store']);

    });

    Route::middleware(['user:is,"manager"'])->group(function() {

        Route::apiResource('vaccinator', App\Http\Controllers\VaccinatorController::class);
        
        Route::apiResource('receptionist', App\Http\Controllers\ReceptionistController::class);
        
        Route::get('employee', [App\Http\Controllers\EmployeeController::class, "index"]);

        Route::get('employee/{user}', [App\Http\Controllers\EmployeeController::class, "show"]);

        Route::put('employee/{user}', [App\Http\Controllers\EmployeeController::class, "update"]);

        Route::get('manager-center', [App\Http\Controllers\ManagerCenterController::class, 'show']);

        Route::get('manager-me', [App\Http\Controllers\ManagerController::class, 'me']);
        
    });

});
