<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Widgets;

use App\Models\AgreementOfSale;
use App\Models\Installment;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatementWidget extends BaseWidget
{

    public $agreement_id;


    protected function getStats(): array
    {

        $totalPaid = Payment::where('agreement_of_sale_id',$this->agreement_id)->sum('amount_paid');
        $totalPenalty = Installment::where('agreement_of_sale_id',$this->agreement_id)->sum('penalty');

        $agreement   = AgreementOfSale::find($this->agreement_id);
        $totalPrice = $agreement->stand_price +  $agreement->other_costs;
        $balance =  $totalPrice - ($totalPaid + $totalPenalty);



        return [
            Stat::make('Total Paid', '$'.$totalPaid),
            Stat::make('Total Penalty', '$'.$totalPenalty),
            Stat::make('Total Balance', '$'.$balance),
        ];
    }
}
