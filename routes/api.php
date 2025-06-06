<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::controller(CheckoutController::class)->group(function () {
    Route::post('/checkout', 'process');
});
