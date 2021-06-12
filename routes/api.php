<?php

use App\Http\Controllers\JWTController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth', [JWTController::class, 'store']);

Route::match(['put', 'patch'], 'auth', [JWTController::class, 'update']);

Route::delete('auth', [JWTController::class, 'destroy']);
