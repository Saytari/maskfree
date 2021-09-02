<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TakerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\VaccinatorController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\AppointmentController;


/*
|--------------------------------------------------------------------------
| Android Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes intended for android
| clients.
| nevertheless, these routes my be used at some point by web client.
|
*/



Route::apiResource('user',App\Http\Controllers\TakerController::class);
//register
Route::post('user/takers',[TakerController::class,'store']);

Route::post('user/managers',[ManagerController::class,'store']);
Route::post('user/vaccinators',[VaccinatorController::class,'store']);
Route::post('user/receptionist',[ReceptionistController::class,'store']);
Route::post('ss',[AppointmentController::class,'scheduling']);

Route::middleware(['jwt.auth'])->group(function() {

  //  Route::middleware(['user:is,"taker"'])->group(function() {

        Route::post('request/requests',[RequestController::class,'store']);

        Route::get('takers/{user}/hasAppointment',[TakerController::class, 'hasAppointment']);
        Route::get('takers/{user}/hasRequest',[TakerController::class, 'hasRequest']);
        Route::get('center/centers',[CenterController::class, 'index']);

        Route::delete('appointments/{appointment}',[AppointmentController::class,'destroy']);
        Route::delete('requests/{request}',[RequestController::class,'destroy']);
        Route::apiResource('request', App\Http\Controllers\RequestController::class);
        Route::get('appointment/appointments', [AppointmentController::class, 'allTakerAppointment']);

        Route::get('taker/takers/myProfile',[TakerController::class, 'showMyProfile']);
        Route::get('taker/takers/couldOrder',[TakerController::class, 'couldOrder']);

  //  });

});
    Route::middleware(['user:is,"receptionist"'])->group(function() {


        Route::get('receptionist/takers/{user}',[ReceptionistController::class, 'showTakerProfile']);
        Route::post('receptionist/{user}',[ReceptionistController::class,'verifiedTakerData']);

});
    Route::middleware(['user:is,"vaccinator"'])->group(function() {

        Route::get('vaccinator/takers/{user}',[VaccinatorController::class, 'showTakerProfile']);


        Route::post('vaccinator/appointments/{user}',[VaccinatorController::class, 'vaccineConfirm']);


    });





