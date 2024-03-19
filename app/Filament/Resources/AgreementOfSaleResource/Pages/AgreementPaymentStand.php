<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Filament\Resources\PaymentResource;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Stand;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

use Filament\Forms;
use Filament\Forms\Form;

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
                TextColumn::make('client.first_name')->searchable(),
                TextColumn::make('receipt_date')->date()->label('Date Paid')->searchable(),
                TextColumn::make('payment_method'),
                TextColumn::make('currency'),
                TextColumn::make('amount_paid')->searchable(),
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


    public function getHeaderActions() : array
    {
        return [
            CreateAction::make('addPayment')
                ->label('Add Payment')
                ->model(Payment::class)
                ->form([
                    Forms\Components\Section::make()->schema([

                        Forms\Components\Hidden::make('project_id')->default(Filament::getTenant()->id),
                        Forms\Components\Hidden::make('client_id')->default($this->record->client_id),
                        Forms\Components\Hidden::make('agreement_of_sale_id')->default($this->record->id),
                        Forms\Components\Hidden::make('stand_number')->default(Stand::where('agreement_of_sale_id',$this->record->id)->first()['stand_number']),


                        Forms\Components\DatePicker::make('receipt_date')
                            ->native(false)
                            ->label('Receipt Date')
                            ->closeOnDateSelection()
                            ->default(date('Y-m-d'))
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Amount Paid')
                            ->default($this->record->monthly_payment)
                            ->numeric()
                            ->columnSpan(4),

                        Forms\Components\Select::make('currency')
                            ->options([
                                'usd'         =>'USD',
                                'rtgs'      =>'RTGS',
                            ])
                            ->default('usd')
                            ->label('Select Currency')
                            ->columnSpan(4),

                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash'         =>'Cash',
                                'ecocash'      =>'EcoCash',
                                'onemoney'     =>'One Money',
                                'zipt'         =>'ZipIt',
                                'banktransfer' =>'Bank Transfer',
                            ])
                            ->default('cash')
                            ->label('Payment method')
                            ->columnSpan(4),

                        Forms\Components\Select::make('installment_id')
                            ->options(Installment::where('agreement_of_sale_id',$this->record->id)->whereNull('is_paid_infull')->pluck('month','id'))
                            ->label('Select Installment Month')
                            ->columnSpan(3),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->label('Stand Description')
                            ->columnSpan(5),


                    ])->columns(12)
                ])
        ];
    }

}
