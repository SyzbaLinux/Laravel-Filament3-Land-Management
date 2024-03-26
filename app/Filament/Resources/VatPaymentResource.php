<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VatPaymentResource\Pages;
use App\Filament\Resources\VatPaymentResource\RelationManagers;
use App\Models\VatPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VatPaymentResource extends Resource
{
    protected static ?string $model = VatPayment::class;

    protected static ?string $navigationIcon = 'solar--wallet-money-linear';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListVatPayments::route('/'),
            'create' => Pages\CreateVatPayment::route('/create'),
            'edit' => Pages\EditVatPayment::route('/{record}/edit'),
        ];
    }
}
