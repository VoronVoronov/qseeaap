<?php

use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\MenuController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\TariffController;
use App\Http\Controllers\API\v1\UserController;


Route::group([
    'prefix' => 'user',
], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::middleware(['auth:api'])->group(function () {
        Route::post('check-code', [UserController::class, 'checkCode']);
        Route::post('send-sms', [UserController::class, 'sendSms']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::get('me', [UserController::class, 'getUser'])->name('getUser');
        Route::middleware(['check.active'])->group(function () {
            Route::apiResource('menu', MenuController::class);
            Route::get('tariff', [TariffController::class, 'index']);
            Route::middleware(['check.tariff.access'])->group(function () {
                Route::apiResources([
                    'category' => CategoryController::class,
                    'product' => ProductController::class,
                ]);
            });
        });
    });
});
