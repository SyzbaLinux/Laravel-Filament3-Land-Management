<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Models\AgreementOfSale;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Penalt;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

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

        $aggrement = AgreementOfSale::find($this->record->id);


        return $table
            ->query(
                Penalt::query()
                    ->where('agreement_of_sale_id', $this->record->id) // Assuming $this->record is the current AgreementOfSale instance
            )
            ->columns([
                TextColumn::make('date_generated')->date()->label('Date Generated'),
                TextColumn::make('percentage')->suffix('%'),
                TextColumn::make('amount_charged')->prefix('$'),
                TextColumn::make('amount_paid')->prefix('$'),
                TextColumn::make('date_of_payment')->date(),
            ])
            ->actions([
                    EditAction::make()
                        ->form([
                            Section::make()
                                ->schema([

                                    TextInput::make('amount_charged')
                                        ->prefix('$')
                                        ->label('Enter Amount')
                                        ->numeric()
                                        ->columnSpan(4),

                                    DatePicker::make('date_generated')
                                        ->native(false)
                                        ->maxDate(now())
                                        ->label('Date generated')
                                        ->default(now())
                                        ->columnSpan(4),

                                    TextInput::make('percentage')
                                        ->suffix('%')
                                        ->numeric()
                                        ->default(10)
                                        ->columnSpan(4),

                                    Select::make('generated_for_month')
                                        ->options([
                                            1=>'January',
                                            2=>'February',
                                            3=>'March',
                                            4=>'April',
                                            5=>'May',
                                            6=>'June',
                                            7=>'July',
                                            8=>'August',
                                            9=>'September',
                                            10=>'October',
                                            11=>'November',
                                            12=>'December',
                                        ])
                                        ->preload()
                                        ->searchable()
                                        ->label('Select Penalty Month')
                                        ->columnSpan(6),

                                    Select::make('generated_for_year')
                                        ->options(
                                            Installment::where('agreement_of_sale_id',$this->record->id)
                                                ->distinct()
                                                ->pluck('year', 'year')
                                                ->toArray())
                                        ->searchable()
                                        ->label('Select Penalty Year')
                                        ->columnSpan(6),

                                ])
                                ->columns(12)
                                ->columnSpanFull(),

                            Section::make('Payments')
                                ->description('Add details of Payment details if client has paid')
                                ->schema([

                                    Select::make('payment_id')
                                        ->options(Payment::query()->pluck('id','id'))
                                        ->preload()
                                        ->searchable()
                                        ->label('Select Payment')
                                        ->columnSpan(4),

                                    TextInput::make('amount_paid')
                                        ->prefix('$')
                                        ->numeric()
                                        ->label('Amount Paid')
                                        ->columnSpan(4),


                                    DatePicker::make('date_of_payment')
                                        ->native(false)
                                        ->maxDate(now())
                                        ->label('Date Paid')
                                        ->default(now())
                                        ->columnSpan(4),

                                ])
                                ->columns(12)
                                ->columnSpanFull(),

                            Hidden::make('project_id')->default(Filament::getTenant()->id),
                            Hidden::make('agreement_of_sale_id')->default($this->record->id),
                            Hidden::make('client_id')->default($aggrement->client_id),
                            Hidden::make('stand_id')->default($aggrement->stand_id),


                        ])
                        ->slideOver()
                        ->button(),

                    DeleteAction::make()
                        ->button(),
            ])
            ->headerActions([
                Action::make('Add Penalty')
                    ->form([
                        Section::make()
                            ->schema([

                                TextInput::make('amount_charged')
                                    ->prefix('$')
                                    ->label('Enter Amount')
                                    ->numeric()
                                    ->columnSpan(4),

                                DatePicker::make('date_generated')
                                    ->native(false)
                                    ->maxDate(now())
                                    ->label('Date generated')
                                    ->default(now())
                                    ->columnSpan(4),

                                TextInput::make('percentage')
                                    ->suffix('%')
                                    ->numeric()
                                    ->default(10)
                                    ->columnSpan(4),

                                Select::make('generated_for_month')
                                    ->options([
                                        1=>'January',
                                        2=>'February',
                                        3=>'March',
                                        4=>'April',
                                        5=>'May',
                                        6=>'June',
                                        7=>'July',
                                        8=>'August',
                                        9=>'September',
                                        10=>'October',
                                        11=>'November',
                                        12=>'December',
                                    ])
                                    ->preload()
                                    ->searchable()
                                    ->label('Select Penalty Month')
                                    ->columnSpan(6),

                                Select::make('generated_for_year')
                                    ->options(
                                        Installment::where('agreement_of_sale_id',$this->record->id)
                                            ->distinct()
                                            ->pluck('year', 'year')
                                            ->toArray())
                                    ->searchable()
                                    ->label('Select Penalty Year')
                                    ->columnSpan(6),

                            ])
                            ->columns(12)
                            ->columnSpanFull(),

                        Section::make('Payments')
                            ->description('Add details of Payment details if client has paid')
                            ->schema([

                                Select::make('payment_id')
                                    ->options(Payment::query()->pluck('id','id'))
                                    ->preload()
                                    ->searchable()
                                    ->label('Select Payment')
                                    ->columnSpan(4),

                                TextInput::make('amount_paid')
                                    ->prefix('$')
                                    ->numeric()
                                    ->label('Amount Paid')
                                    ->columnSpan(4),


                                DatePicker::make('date_of_payment')
                                    ->native(false)
                                    ->maxDate(now())
                                    ->label('Date Paid')
                                    ->default(now())
                                    ->columnSpan(4),

                            ])
                            ->columns(12)
                            ->columnSpanFull(),

                        Hidden::make('project_id')->default(Filament::getTenant()->id),
                        Hidden::make('agreement_of_sale_id')->default($this->record->id),
                        Hidden::make('client_id')->default($aggrement->client_id),
                        Hidden::make('stand_id')->default($aggrement->stand_id),


                    ])
                    ->action(function (array $data): void {
                        Penalt::create($data);
                        Notification::make()
                            ->title('Saved successfully')
                            ->body('Penalty details have been saved successfully')
                            ->success()
                            ->send();
                    })
                    ->slideOver()
            ]);
    }


}
