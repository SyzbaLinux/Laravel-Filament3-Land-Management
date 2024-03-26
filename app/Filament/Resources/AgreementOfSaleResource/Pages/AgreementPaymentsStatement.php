<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Models\Installment;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\View\View;

class AgreementPaymentsStatement extends ViewRecord
{
    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $navigationLabel = 'View Statement';
    protected static ?string $navigationIcon = 'statement';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payments-statement';


    public function getHeaderActions() : array
    {
        return [
            ViewAction::make('exportExcel')->label('View Detailed Statement')
                ->url(route('client-statement',1))
                ->color('success'),
        ];
    }
}
