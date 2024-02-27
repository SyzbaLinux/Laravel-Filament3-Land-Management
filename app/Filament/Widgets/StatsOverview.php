<?php

namespace App\Filament\Resources\UnitResource\Widgets;

use App\Models\AgreementOfSale;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Stand;
use App\Models\Unit;
use App\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon; // Import Carbon for date manipulation

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Clients', Client::count())
                 ->icon('tenants')
                 ->description('Total Clients')
                 ->color('success'),

            Stat::make('Stands', Stand::count())
                ->icon('shop')
                ->description('Total Stands Recorded')
                 ->color('primary'),


            Stat::make('Sales', AgreementOfSale::count())
                ->icon('tenants')
                ->description('Total Stands Sold')
                ->color('secondary'),

            Stat::make('Payments', '$ '.Payment::sum('amount_paid'))
                ->description('Total Payments Recorded')
                ->icon('payments')
                 ->color('warning'),
        ];
    }
}
