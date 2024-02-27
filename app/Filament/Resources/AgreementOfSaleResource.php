<?php

namespace App\Filament\Resources;

use App\Filament\Imports\AgreementOfSaleImporter;
use App\Filament\Resources\AgreementOfSaleResource\Pages;
use App\Filament\Resources\AgreementOfSaleResource\RelationManagers;
use App\Models\AgreementOfSale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgreementOfSaleResource extends Resource
{
    protected static ?string $model = AgreementOfSale::class;

    protected static ?string $navigationIcon = 'agreementofsale';

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
                    ->columnSpan(4),

                Forms\Components\Select::make('stand_id')
                    ->relationship('stand','stand_number')
                    ->preload()
                    ->required()
                    ->label('Select Stand')
                    ->searchable()
                    ->options( fn () => \App\Models\Stand::whereNotNull('stand_number')->whereDoesntHave('client')->pluck('stand_number', 'id'))
                    ->columnSpan(4),

                Forms\Components\TextInput::make('monthly_payment')
                    ->label('Monthly Payment')
                    ->numeric()
                    ->columnSpan(4),



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
                    ->columnSpan(4),

                Forms\Components\FileUpload::make('document')
                    ->columnSpan(4),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.first_name')->searchable(),
                Tables\Columns\TextColumn::make('date_signed')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->date()->searchable(),
                Tables\Columns\TextColumn::make('end_date')->date()->searchable(),
                Tables\Columns\TextColumn::make('agreement_fee')->prefix('$')->searchable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgreementOfSales::route('/'),
            'create' => Pages\CreateAgreementOfSale::route('/create'),
            'edit' => Pages\EditAgreementOfSale::route('/{record}/edit'),
        ];
    }
}
