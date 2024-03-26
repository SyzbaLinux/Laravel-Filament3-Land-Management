<?php

namespace App\Filament\Resources;

use App\Filament\Imports\PaymentsImporter;
use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Client;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'payments';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client','first_name')
                    ->preload()
                    ->label('Select Client')
                    ->searchable()
                    ->columnSpan(4),

                Forms\Components\Select::make('stand_number')
                    ->relationship(
                        'stand',
                        'stand_number',
                        modifyQueryUsing: function (Builder $query, Get $get){
                            $client = $get('client_id');
                            if($client){
                                $query->whereNotNull('stand_number')->where('client_id',$client);
                            }else{
                                $query->where('stand_number','0.2NULL'); //0.2 coz no stand number has that number
                            }},
                    )
                    ->preload()
                    ->label('Select Stand')
                    ->searchable()
                    ->columnSpan(4),

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

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->label('Stand Description')
                    ->columnSpan(6),

//                Forms\Components\Textarea::make('amount_in_words')
//                    ->rows(3)
//                    ->label('Amount in Words')
//                    ->columnSpan(6),

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
                Tables\Columns\TextColumn::make('receipt_date')->searchable()->date()->sortable(),
                Tables\Columns\TextColumn::make('stand_number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount_paid')->prefix('$')->searchable()->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PaymentsImporter::class)
                    ->label('Import Payments')
            ])
            ;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

}
