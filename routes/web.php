<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'cabinet'
], function () {
    Route::get('{any}', function () {
        return view('cabinet');
    })->where('any', '.*');
});

Route::domain('cabinet.' . env('APP_URL'))->group(function () {
    Route::get('{any}', function () {
        return view('cabinet');
    })->where('any', '.*');
});

Route::get('{any}', function () {
    return view('cabinet');
})->where('any', '.*');
