<?php

namespace App\Filament\Resources;

use App\Filament\Imports\AgreementOfSaleImporter;
use App\Filament\Resources\AgreementOfSaleResource\Pages;
use App\Filament\Resources\AgreementOfSaleResource\RelationManagers;
use App\Filament\Resources\ClientResource\Pages\EditClient;
use App\Models\AgreementOfSale;
use App\Models\Client;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
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
                    ->columnSpan(4),

                Forms\Components\Select::make('stand_id')
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
                Tables\Columns\TextColumn::make('client.full_name')
                    ->label('Client Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->client->first_name . ' ' . $record->client->last_name),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('client.first_name')
            ]);
    }
}
