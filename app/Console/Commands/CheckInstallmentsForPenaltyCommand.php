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
    protected $signature = 'check:installments';

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


        Installment::where('year', '<=', $currentYear)
            ->whereNull('payment_id')
            ->chunk(100, function ($installments){
                foreach ($installments as $installment ){
                    //add penalt
                    $agreement = AgreementOfSale::find($installment->agreement_of_sale_id);
                     //$installment  = Installment::find()
                        $installment->penalty   =  (10 / 100) * $agreement->monthly_payment;
                        $installment->processed =  1;
                        $installment->save();
                }

            });

    }

}
