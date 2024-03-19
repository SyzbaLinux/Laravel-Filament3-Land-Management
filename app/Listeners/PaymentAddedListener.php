<?php

namespace App\Listeners;

use App\Models\Installment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PaymentAddedListener  implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //Add payment id to Installments

        if($event->payment->installment_id){

            $installment                 = Installment::find($event->payment->installment_id);


            if($event->payment->payPenalty ===1){

                 $installment->penalty_paid_amount     = $event->payment->amount_paid;
                 $installment->penalty_payment_id      = $event->payment->id;
                 $installment->date_penalty_paid       = $event->payment->receipt_date;

                if($event->payment->amount_paid >= $installment->penalty)
                {
                    $installment->is_penalty_paid_infull = 1;
                }


            }else{


                $installment->payment_id     = $event->payment->id;
                $installment->amount         = $event->payment->amount_paid;

                if($event->payment->amount_paid >= $installment->amount)
                {
                    $installment->is_paid_infull = 1;
                }
            }

            $installment->save();

        }

    }
}
