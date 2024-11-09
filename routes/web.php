<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelOrderController;
use Illuminate\Support\Facades\Route;

// Rota para visualizar se a aplicação está rodando corretamente
Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::controller(TravelOrderController::class)->group(function () {        
        Route::get('/api/orders', 'index')->name('orders.index');
        Route::post('/api/orders', 'store')->name('orders.store');
        Route::get('/api/orders/{order}', 'show')->name('orders.show');
        Route::put('/api/orders/{order}', 'update')->name('orders.update');
    });

    Route::post('/api/logout', [AuthController::class, 'logout'])->name('logout');
});
