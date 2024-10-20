<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/api/orders', [OrderController::class, 'store'])
    ->name('api.orders.store');
Route::get('/api/orders/{id}', [OrderController::class, 'show'])
    ->name('api.orders.show');
