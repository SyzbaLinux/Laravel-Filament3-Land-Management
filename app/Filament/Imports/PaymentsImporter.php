<?php

namespace App\Filament\Imports;

use App\Models\Payment;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PaymentsImporter extends Importer
{
    protected static ?string $model = Payment::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('project_id'),
            ImportColumn::make('client_id'),
            ImportColumn::make('stand_id'),
            ImportColumn::make('receipt_number'),
            ImportColumn::make('receipt_date'),
            ImportColumn::make('amount_paid'),
            ImportColumn::make('currency'),
            ImportColumn::make('description'),
        ];
    }

    public function resolveRecord(): ?Payment
    {
        // return Payments::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Payment();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your payments import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
