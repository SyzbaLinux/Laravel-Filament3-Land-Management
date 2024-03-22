<?php

namespace App\Listeners;

use App\Models\Installment;
use App\Models\Stand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

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

    //Create blank installments sheet

        $start_date = Carbon::parse($event->agreementOfSale->start_date);
        $end_date   = Carbon::parse($event->agreementOfSale->end_date);

    // Ensure the start date is the first of the month for accurate calculation
        $start_date->startOfMonth();

    // Calculate the period between the start and end dates
        $period = $start_date->diffInMonths($end_date) + 1; // +1 to include the end month

        for ($i = 0; $i < $period; $i++) {
            // For each month in the period, create a new installment
            $installmentDate = $start_date->copy()->addMonths($i);

            $installment = new Installment();
            $installment->project_id           = $event->agreementOfSale->project_id;
            $installment->client_id            = $event->agreementOfSale->client_id;
            $installment->stand_id             = $event->agreementOfSale->stand_id;
            $installment->agreement_of_sale_id = $event->agreementOfSale->id;
            $installment->month                = $installmentDate->month; // Extract the month
            $installment->year                 = $installmentDate->year;  // Extract the year
            $installment->save();
        }
    }
}
