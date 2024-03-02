<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Filament\Resources\PaymentResource;
use App\Models\Payment;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Filament\Infolists\Infolist;


class AgreementPaymentStand extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    public $selectedPaymentId;

    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $title = 'Payments';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payment-stand';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->select('payments.*') // Adjust based on your actual column names
                    ->join('stands', 'stands.stand_number', '=', 'payments.stand_number')
                    ->where('stands.agreement_of_sale_id', $this->record->id) // Assuming $this->record is the current AgreementOfSale instance
            )
            ->columns([
                TextColumn::make('client.first_name'),
                TextColumn::make('receipt_date')->date()->label('Date Paid'),
                TextColumn::make('payment_method'),
                TextColumn::make('currency'),
                TextColumn::make('amount_paid'),
            ])
            ->actions([
                ViewAction::make('Edit')
                    ->button()
                    ->color('success')
                    ->url(function ($record){
                        return PaymentResource::getUrl('edit',[$record->id]);
                    }),

                ViewAction::make('print')
                    ->icon('pdf')
                    ->color('danger')
                    ->url(fn($record) => route('payment-receipt',$record->id))
                    ->label('Print Receipt'),
            ]);
    }

}
