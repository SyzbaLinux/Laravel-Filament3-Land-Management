<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Models\AgreementOfSale;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Stand;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Form;

class AgreementPaymentsPenalties extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    public $selectedPaymentId;

    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $navigationLabel = 'Penalties';
    protected static ?string $navigationIcon = 'penalt';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payments-penalties';

    public function table(Table $table): Table
    {

        return $table
            ->query(
                Installment::query()
                    ->where('agreement_of_sale_id', $this->record->id)
                    ->whereNotNull('penalty')// Assuming $this->record is the current AgreementOfSale instance
            )
            ->columns([
                TextColumn::make('generated_for_year')
                    ->label('Penalty for(Month Year)')
                    ->searchable(['year', 'month'])
                    ->sortable()
                    ->getStateUsing(fn ($record) => date('M', mktime(0, 0, 0, $record->month, 10))  . '-' . $record->year),

                TextColumn::make('penalty')->prefix('$'),
                TextColumn::make('penalty_paid_amount')->prefix('$'),
                TextColumn::make('penalty_payment_id')->label('Receipt'),
                IconColumn::make('is_penalty_paid_infull')->label('Paid in Full'),
                TextColumn::make('date_penalty_paid')->date()->label('Date Paid'),

            ]);
    }


    public function getHeaderActions() : array
    {
        $aggrement = AgreementOfSale::find($this->record->id);

        return [


            CreateAction::make('addPayment')
                ->label('Pay Penalts')
                ->icon('payments')
                ->model(Payment::class)
                ->form([
                    Forms\Components\Section::make()->schema([

                        Forms\Components\Hidden::make('project_id')->default(Filament::getTenant()->id),
                        Forms\Components\Hidden::make('client_id')->default($aggrement->client_id),
                        Forms\Components\Hidden::make('agreement_of_sale_id')->default($aggrement->id),
                        Forms\Components\Hidden::make('stand_number')->default(Stand::where('agreement_of_sale_id',$aggrement->id)->first()['stand_number']),
                        Forms\Components\Hidden::make('amount_paid'),
                        Forms\Components\Hidden::make('payPenalty')->default(1),


                        Forms\Components\DatePicker::make('receipt_date')
                            ->native(false)
                            ->label('Receipt Date')
                            ->closeOnDateSelection()
                            ->default(date('Y-m-d'))
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Amount Paid')
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
                            ->options(
                                Installment::where('agreement_of_sale_id',$this->record->id)
                                    ->whereNotNull('penalty') //Has Penalt
                                    ->whereNull('penalty_paid_amount') //Penalt not Paid
                                    ->pluck('month','id')
                            )
                            ->label('Select Penalty Month')
                            ->columnSpan(3),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->label('Stand Description')
                            ->columnSpan(5),


                    ])->columns(12)
                ])
                ->slideOver()
        ];
    }

}
