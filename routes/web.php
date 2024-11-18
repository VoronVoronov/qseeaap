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

if(env('APP_ENV') !== 'local') {
    Route::get('/', function () {
        return view('welcome');
    });
}

Route::domain('cabinet.' . env('APP_URL'))->group(function () {
    Route::get('{any}', function () {
        return view('cabinet');
    })->where('any', '.*');
});

Route::get('{any}', function () {
    return view('cabinet');
})->where('any', '.*');
