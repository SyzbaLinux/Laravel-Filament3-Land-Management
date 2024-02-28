<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function receipt($id)
    {

//        $pdf = Pdf::loadView('receipt', ['payment' => Payment::where('id',$id)->firstOrFail()])
//        ->setPaper('a4', 'portrait');
//
//        return $pdf->stream();

        return view('receipt',[
            'payment' => Payment::where('id',$id)->firstOrFail()
        ]);
    }
}
