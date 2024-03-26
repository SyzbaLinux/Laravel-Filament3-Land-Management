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

Route::get('/client-statement/{agreement}', function($agreement){

    $agreementLocal =  \App\Models\AgreementOfSale::find($agreement);

    return view('pdf.statement',[
        'installments' => \App\Models\Installment::where('agreement_of_sale_id',$agreement)->get(),
        'agreement'    => $agreementLocal,
        'client'       => \App\Models\Client::find($agreementLocal->client_id),
        'stand'        => \App\Models\Stand::find($agreementLocal->stand_id),
        'payments'     => \App\Models\Payment::where('agreement_of_sale_id',$agreement)->get(),
    ]);

})->name('client-statement');
