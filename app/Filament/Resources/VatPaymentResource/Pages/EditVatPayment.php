<?php

namespace App\Filament\Resources\VatPaymentResource\Pages;

use App\Filament\Resources\VatPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVatPayment extends EditRecord
{
    protected static string $resource = VatPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
