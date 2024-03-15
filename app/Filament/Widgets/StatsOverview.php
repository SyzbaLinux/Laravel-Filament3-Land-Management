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
use Filament\Facades\Filament;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Clients', Client::where('project_id',Filament::getTenant()->id)->count())
                 ->icon('tenants')
                 ->description('Total Clients')
                 ->color('success'),

            Stat::make('Stands', Stand::where('project_id',Filament::getTenant()->id)->count())
                ->icon('shop')
                ->description('Total Stands Recorded')
                 ->color('primary'),


            Stat::make('Sales', AgreementOfSale::where('project_id',Filament::getTenant()->id)->count())
                ->icon('tenants')
                ->description('Total Stands Sold')
                ->color('secondary'),

            Stat::make('Payments', '$ '.Payment::where('project_id',Filament::getTenant()->id)->sum('amount_paid'))
                ->description('Total Payments Recorded')
                ->icon('payments')
                 ->color('warning'),
        ];
    }
}
