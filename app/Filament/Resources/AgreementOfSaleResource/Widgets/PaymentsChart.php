<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Widgets;

use App\Models\AgreementOfSale;
use App\Models\Payment;
use App\Models\Stand;
use Filament\Actions\Concerns\InteractsWithRecord;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PaymentsChart extends ApexChartWidget
{
   use InteractsWithRecord;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'paymentsChart';
    protected static ?string $pollingInterval = null;

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Payments Trends';



    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    public $agreement_id;


    protected function getOptions(): array
    {

        $agreement = AgreementOfSale::find($this->agreement_id);
        $stand     = Stand::find($agreement->stand_id);


        $start_date = Carbon::parse($agreement->start_date); // Parse the start date if it's not a Carbon instance.
        $pastYears = Carbon::now()->diffInYears($start_date);

       // dd(date('Y', strtotime($agreement->start_date))  + 1);

        $series = [];

        for($i = $pastYears; $i >= 0; $i--){

            $yearData = Trend::query(Payment::query()->where('stand_number',$stand->stand_number))
                ->dateColumn('receipt_date')
                ->between(
                    start: now()->startOfYear()->subYears($i),
                    end: now()->endOfYear()->subYears($i),
                )
                ->perMonth()
                ->sum('amount_paid');

           $data = [
                'name' => now()->startOfYear()->subYears($i)->format('Y') ,
                'data' => $yearData->map(fn (TrendValue $value) => $value->aggregate),
            ];

           array_push($series, $data);
        }





        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
            ],
            'series' =>  $series,
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b','#049638','#881c1c','#3b82f6','#000','#FF9800'],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }
}
