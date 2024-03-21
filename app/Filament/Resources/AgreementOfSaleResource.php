<?php

namespace App\Filament\Resources;

use App\Filament\Imports\AgreementOfSaleImporter;
use App\Filament\Resources\AgreementOfSaleResource\Pages;
use App\Filament\Resources\AgreementOfSaleResource\RelationManagers;
use App\Filament\Resources\ClientResource\Pages\EditClient;
use App\Models\AgreementOfSale;
use App\Models\Client;
use App\Models\Stand;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;

class  AgreementOfSaleResource extends Resource
{
    protected static ?string $model = AgreementOfSale::class;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationIcon = 'agreementofsale';
    protected static ?string $navigationLabel = 'Clients & Contracts';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('client_id')
                    ->relationship('client','first_name')
                    ->preload()
                    ->label('Select Client')
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Section::make('Tenant Details')->schema([

                            Forms\Components\Hidden::make('project_id')->default(Filament::getTenant()->id),

                            Forms\Components\TextInput::make('first_name')
                                ->required()
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('middle_name')
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('last_name')
                                ->required()
                                ->columnSpan(3),

                            Forms\Components\DatePicker::make('dob')
                                ->native(false)
                                ->closeOnDateSelection()
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('email')
                                ->columnSpan(4),

                            Forms\Components\TextInput::make('phone')
                                ->columnSpan(4),

                            Forms\Components\TextInput::make('natID')
                                ->label('National ID')
                                ->columnSpan(4),

                            Forms\Components\Textarea::make('address')
                                ->columnSpan(6),

                        ])->columns(12)
                    ])
                    ->columnSpan(4),

                Forms\Components\Select::make('stand_id')
                    ->preload()
                    ->required()
                    ->label('Select Stand')
                    ->searchable()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Builder $query, Get $get, Forms\Set $set, $state){

                        if($state){
                            $stand = Stand::find($get('stand_id'));
                            $set('stand_price', $stand->price);
                            $set('other_costs', $stand->electrification_costs);


                            if($get('stand_price')
                                &&
                                $get('other_costs')
                                &&
                                $get('number_of_installments')
                                &&
                                $get('deposit')
                            ){

                                $total       = $get('stand_price') + $get('other_costs') ;
                                $balance     = $total - $get('deposit');
                                $monthly     = number_format($balance/$get('number_of_installments'),2);
                                $set('monthly_payment', $monthly);

                            }
                        }
                    })
                    ->createOptionForm([
                        Forms\Components\Section::make()->schema([

                            Forms\Components\Hidden::make('project_id')->default(Filament::getTenant()->id),


                            Forms\Components\TextInput::make('stand_number')
                                ->label('Stand No')
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('square_metres')
                                ->label('Stand Square Metres')
                                ->numeric()
                                ->default(300)
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('price')
                                ->label('Stand Price')
                                ->numeric()
                                ->columnSpan(3),

                            Forms\Components\TextInput::make('electrification_costs')
                                ->label('Other Costs')
                                ->numeric()
                                ->columnSpan(3),

                        ])->columns(12)
                    ])
                    ->createOptionUsing(function (array $data): int {
                        return Stand::create($data)->getKey();
                    })
                    ->options( fn () => \App\Models\Stand::whereNotNull('stand_number')->whereDoesntHave('client')->pluck('stand_number', 'id'))
                    ->columnSpan(4),

                Forms\Components\TextInput::make('stand_price')
                    ->label('Stand Price')
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Builder $query, Get $get, Forms\Set $set){
                        if($get('stand_price')
                            &&
                            $get('other_costs')
                            &&
                            $get('number_of_installments')
                            &&
                            $get('deposit')
                        ){
                            $price       =   $get('stand_price');
                            $other_costs =   $get('other_costs');
                            $total       = $price + $other_costs;
                            $balance     = $total - $get('deposit');
                            $monthly     = number_format($balance/$get('number_of_installments'),2);
                            $set('monthly_payment', $monthly);
                        }
                    })
                    ->columnSpan(4),

                //Pricing and Installments

                Forms\Components\Section::make('Pricing & Payments')->schema([

                    Forms\Components\TextInput::make('other_costs')
                        ->label('Other Costs')
                        ->numeric()
                        ->default(2600)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Builder $query, Get $get, Forms\Set $set){
                            if($get('stand_price')
                                &&
                                $get('other_costs')
                                &&
                                $get('number_of_installments')
                                &&
                                $get('deposit')
                            ){
                                $price       =   $get('stand_price');
                                $other_costs =   $get('other_costs');
                                $total       = $price + $other_costs;
                                $balance     = $total - $get('deposit');
                                $monthly     = number_format($balance/$get('number_of_installments'),2);
                                $set('monthly_payment', $monthly);
                            }
                        })
                        ->columnSpan(3),


                    Forms\Components\TextInput::make('deposit')
                        ->label('Deposit Paid')
                        ->numeric()
                        ->default(300)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Builder $query, Get $get, Forms\Set $set){
                            if($get('stand_price')
                                &&
                                $get('other_costs')
                                &&
                                $get('number_of_installments')
                                &&
                                $get('deposit')
                            ){
                                $price       =   $get('stand_price');
                                $other_costs =   $get('other_costs');
                                $total       = $price + $other_costs;
                                $balance     = $total - $get('deposit');
                                $monthly     = number_format($balance/$get('number_of_installments'),2);
                                $set('monthly_payment', $monthly);
                            }
                        })
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('number_of_installments')
                        ->label('Number of Installments')
                        ->numeric()
                        ->default(72)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Builder $query, Get $get, Forms\Set $set){
                            if($get('stand_price')
                                &&
                                $get('other_costs')
                                &&
                                $get('number_of_installments')
                                &&
                                $get('deposit')
                            ){
                                $price       = $get('stand_price');
                                $other_costs = $get('other_costs');
                                $total       = $price + $other_costs;
                                $balance     = $total - $get('deposit');
                                $monthly     = number_format($balance/$get('number_of_installments'),2);
                                $set('monthly_payment', $monthly);
                            }
                        })
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('monthly_payment')
                        ->label('Monthly Payment')
                        ->numeric()
                        ->dehydrated()
                        ->columnSpan(3),



                ])->columns(12),



                Forms\Components\DatePicker::make('date_signed')
                    ->native(false)
                    ->label('Start Signed')
                    ->closeOnDateSelection()
                    ->default(date('Y-m-d'))
                    ->columnSpan(6),

                Forms\Components\TextInput::make('agreement_fee')
                    ->label('Agreement Fee')
                    ->numeric()
                    ->columnSpan(6),


                Forms\Components\DatePicker::make('start_date')
                    ->native(false)
                    ->label('Start Date')
                    ->closeOnDateSelection()
                    ->default(date('Y-m-d'))
                    ->columnSpan(3),

                Forms\Components\DatePicker::make('end_date')
                    ->native(false)
                    ->label('End Date')
                    ->closeOnDateSelection()
                    ->default(date('Y-m-d'))
                    ->columnSpan(3),

                Forms\Components\Toggle::make('has_vat')
                    ->label('Has VAT')
                    ->columnSpan(2),

                Forms\Components\Toggle::make('has_endowments')
                    ->label('Has Endowments')
                    ->columnSpan(3),

                Forms\Components\FileUpload::make('document')
                    ->columnSpan(4),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.full_name')
                    ->label('Client Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->client->first_name . ' ' . $record->client->last_name),
                Tables\Columns\TextColumn::make('date_signed')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->date()->searchable(),
                Tables\Columns\TextColumn::make('end_date')->date()->searchable(),
                Tables\Columns\TextColumn::make('monthly_payment')->prefix('$')->searchable(),
                Tables\Columns\TextColumn::make('agreement_fee')->prefix('$')->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(AgreementOfSaleImporter::class)
                    ->label('Import Agreements')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'     => Pages\ListAgreementOfSales::route('/'),
            'create'    => Pages\CreateAgreementOfSale::route('/create'),
            'edit'      => Pages\EditAgreementOfSale::route('/{record}/edit'),
            'view'      => Pages\ViewAgreemnt::route('/{record}/view'),
            'payments'  => Pages\AgreementPaymentStand::route('/{record}/payments'),
            'statement' => Pages\AgreementPaymentsStatement::route('/{record}/statement'),
            'penalties' => Pages\AgreementPaymentsPenalties::route('/{record}/penalties'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewAgreemnt::class,
            Pages\AgreementPaymentStand::class,
            Pages\AgreementPaymentsPenalties::class,
            Pages\AgreementPaymentsStatement::class,
            Pages\EditAgreementOfSale::class,
        ]);
    }

}
