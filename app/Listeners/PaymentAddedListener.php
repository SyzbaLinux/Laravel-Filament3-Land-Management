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
            $installment->payment_id     = $event->payment->id;
            $installment->amount         = $event->payment->amount_paid;

            if($event->payment->amount_paid >= $installment->amount)
            { // if amount is greater than install set as paid in full if it can pay the next add for the next

                $installment->is_paid_infull = 1;
            }

            $installment->save();

        }

    }
}
