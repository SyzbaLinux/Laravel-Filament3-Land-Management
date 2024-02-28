<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgreementOfSale extends EditRecord
{
    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $title = 'Edit Details';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
