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

Route::redirect('/', '/admin/login')->name('login');


Route::get('/payment-receipt/{payment}', [\App\Http\Controllers\PaymentController::class,'receipt'])
    ->name('payment-receipt');

Route::get('/link-payments/{agreement}', [\App\Http\Controllers\PaymentController::class,'link'] )
    ->name('payment-link');
