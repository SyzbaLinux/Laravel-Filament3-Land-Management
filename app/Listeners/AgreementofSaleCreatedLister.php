<?php

namespace App\Listeners;

use App\Models\Stand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AgreementofSaleCreatedLister implements ShouldQueue
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
         $stand = Stand::find($event->agreementOfSale->stand_id);
         $stand->is_taken = 1;
         $stand->client_id = $event->agreementOfSale->client_id;
         $stand->agreement_of_sale_id = $event->agreementOfSale->id;
         $stand->save();
    }
}
