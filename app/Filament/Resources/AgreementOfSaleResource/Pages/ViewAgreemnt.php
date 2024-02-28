<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAgreemnt extends ViewRecord
{
    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $title = 'Details';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
}
