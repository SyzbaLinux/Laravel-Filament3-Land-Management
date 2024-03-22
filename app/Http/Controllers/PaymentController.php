<?php

namespace App\Http\Controllers;

use App\Models\AgreementOfSale;
use App\Models\Installment;
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








    public function link(Request $request)
    {

        $payments     = Payment::where('agreement_of_sale_id',$request->agreement)->get();
        $installments = Installment::where('agreement_of_sale_id',$request->agreement)->limit(count($payments))->get();


        if(count($payments) >0){

            foreach ($payments as $index => $payment){
                foreach ($installments as $instIndex => $installment){
                    if($index === $instIndex){
                        $installment->payment_id = $payment->id;
                        $installment->save();
                        $payment->installment_id = $installment->id;
                        $payment->save();
                    }
                }
            }
        }

        return back();
    }





}
