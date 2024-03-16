<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource\Pages\ViewAgreemnt;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientContracts extends ManageRelatedRecords
{
    protected static string $resource = ClientResource::class;

    protected static string $relationship = 'agreementOfSale';
    protected static ?string $title = 'Agreements of Sale';
    protected static ?string $navigationLabel = 'Agreements of Sale';
    protected static ?string $navigationIcon = 'agreement-signed';

    public static function getNavigationLabel(): string
    {
        return 'Agreement Of Sale';
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('stand.stand_number')->label('Stand No'),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('date_signed')->date(),
                Tables\Columns\TextColumn::make('monthly_payment')->suffix('$'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                ->url(function(){
                    return ViewAgreemnt::getUrl(['record'=> $this->record->id]);
                }),
            ]) ;
    }
}
