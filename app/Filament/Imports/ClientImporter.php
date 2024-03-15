<?php

namespace App\Filament\Imports;

use App\Models\Client;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ClientImporter extends Importer
{
    protected static ?string $model = Client::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name'),
            ImportColumn::make('middle_name'),
            ImportColumn::make('last_name'),
            ImportColumn::make('phone'),
            ImportColumn::make('natID'),
            ImportColumn::make('address'),
            ImportColumn::make('project_id'),
        ];
    }

    public function resolveRecord(): ?Client
    {
        // return Client::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],

//        Galic
        // ]);

        return new Client();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your client import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
