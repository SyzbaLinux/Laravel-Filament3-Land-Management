<?php

namespace App\Filament\Imports;

use App\Models\Stand;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StandImporter extends Importer
{
    protected static ?string $model = Stand::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('square_metres'),
            ImportColumn::make('stand_number'),
            ImportColumn::make('project_id'),
        ];
    }

    public function resolveRecord(): ?Stand
    {
        // return Stand::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Stand();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your stand import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
