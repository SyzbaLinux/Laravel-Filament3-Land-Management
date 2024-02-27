<?php

namespace App\Filament\Imports;

use App\Models\AgreementOfSale;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AgreementOfSaleImporter extends Importer
{
    protected static ?string $model = AgreementOfSale::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('client_id'),
            ImportColumn::make('project_id'),
            ImportColumn::make('stand_id'),
            ImportColumn::make('monthly_payment'),
            ImportColumn::make('date_signed'),
            ImportColumn::make('agreement_fee'),
            ImportColumn::make('start_date'),
            ImportColumn::make('end_date'),
        ];
    }

    public function resolveRecord(): ?AgreementOfSale
    {
        // return AgreementOfSale::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new AgreementOfSale();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your agreement of sale import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
