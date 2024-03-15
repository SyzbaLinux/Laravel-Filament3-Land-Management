<?php

namespace App\Console\Commands;

use App\Models\AgreementOfSale;
use App\Models\Installment;
use App\Models\Penalt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckInstallmentsForPenaltyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:installments-penalty-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check installments for penalty application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->checkInstallmentsForPenalty();
        $this->info('Installments checked for penalties.');
    }

    public   function checkInstallmentsForPenalty()
    {

        // Get the current month and year
        $currentMonth = intval(date('m'));
        $currentYear = intval(date('Y'));

// Query installments that meet the conditions in batches of 100
        Installment::where(function ($query) use ($currentMonth, $currentYear) {
            $query->where('month', '<=', $currentMonth)
                ->where('year', '<=', $currentYear)
                ->whereNull('payment_id')
                ->orWhereHas('payment', function ($query) {
                    $query->where('is_paid_infull', '=', 0);
                });

        })->chunk(100, function ($installments) {



            foreach ($installments as $installment ){

                // Check if a penalty already exists for this installment
                $existingPenalty = Penalt::where('generated_for_month', $installment->month)
                    ->where('generated_for_year', $installment->year)
                    ->where('agreement_of_sale_id', $installment->agreement_of_sale_id)
                    ->first();

//                Log::info('record Found ' .$existingPenalty . ' rec');

                if(!$existingPenalty){

                    // Create a penalty
                    $agreement = AgreementOfSale::find($installment->agreement_of_sale_id);
                    //penalty
                    Penalt::create([
                        'project_id'            => $installment->project_id,
                        'client_id'             => $installment->client_id,
                        'stand_id'              => $installment->stand_id,
                        'agreement_of_sale_id'  => $installment->agreement_of_sale_id,
                        'percentage'            => 10, // Set your percentage here
                        'date_generated'        => now(),
                        'amount_charged'        => (10 / 100) * $agreement->monthly_payment, // Set your amount charged here
                        'generated_for_month'   => $installment->month,
                        'generated_for_year'    => $installment->year
                    ]);
                }
            }

            // For each installment, create a penalty if payment doesn't exist
//            foreach ($installments as $installment) {
//
//                if (!$existingPenalty) {
//
//                }
//            }
        });


    }

}
