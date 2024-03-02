<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;

class AgreementPaymentsPenalties extends ViewRecord
{
    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $navigationLabel = 'Penalties';
    protected static ?string $navigationIcon = 'penalt';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payments-penalties';
}
