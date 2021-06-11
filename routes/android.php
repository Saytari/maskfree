<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get("android", function() {
    return 'android';
});