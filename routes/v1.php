<?php

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\MenuController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'user',
], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::middleware(['auth:api'])->group(function () {
        Route::post('check-code', [UserController::class, 'checkCode']);
        Route::post('send-sms', [UserController::class, 'sendSms']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::middleware(['check.active'])->group(function () {
            Route::get('me', [UserController::class, 'getUser'])->name('getUser');
            Route::apiResources([
                'menu' => MenuController::class,
                'category' => CategoryController::class,
                'product' => ProductController::class,
            ]);
        });
    });
});
