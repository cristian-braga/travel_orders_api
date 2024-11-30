<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelOrderController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::controller(TravelOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::post('/orders', 'store')->name('orders.store');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::put('/orders/{order}', 'update')->name('orders.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
