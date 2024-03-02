<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;

class AgreementPaymentsStatement extends ViewRecord
{
    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $navigationLabel = 'View Statement';
    protected static ?string $navigationIcon = 'statement';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payments-statement';
}
