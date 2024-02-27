<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgreementOfSales extends ListRecords
{
    protected static string $resource = AgreementOfSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
