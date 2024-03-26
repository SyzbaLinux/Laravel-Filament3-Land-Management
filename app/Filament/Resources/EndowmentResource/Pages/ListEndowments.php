<?php

namespace App\Filament\Resources\EndowmentResource\Pages;

use App\Filament\Resources\EndowmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEndowments extends ListRecords
{
    protected static string $resource = EndowmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
