<?php

namespace App\Filament\Resources;

use App\Filament\Imports\StandImporter;
use App\Filament\Resources\StandResource\Pages;
use App\Filament\Resources\StandResource\RelationManagers;
use App\Models\Stand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StandResource extends Resource
{
    protected static ?string $model = Stand::class;

    protected static ?string $navigationIcon = 'map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('is_taken')
                    ->label('Is Stand is Taken?')
                    ->options([
                        true  => 'Yes Stand is Taken',
                        false => 'No its Available',
                    ])
                    ->columnSpan(3),

                Forms\Components\Select::make('client_id')
                    ->relationship('client','first_name')
                    ->preload()
                    ->label('Select Client')
                    ->searchable()
                    ->columnSpan(5),

                Forms\Components\DatePicker::make('listing_date')
                    ->native(false)
                    ->label('Listing Date')
                    ->default(date('Y-m-d'))
                    ->columnSpan(4),

                Forms\Components\TextInput::make('stand_number')
                    ->label('Stand No')
                    ->columnSpan(3),

                Forms\Components\TextInput::make('square_metres')
                    ->label('Stand Square Metres')
                    ->numeric()
                    ->columnSpan(3),

                Forms\Components\Select::make('custom_price')
                    ->label('Pricing Type')
                    ->options([
                        true  => 'Enter Custom Price',
                        false => 'Use Project Price/sm',
                    ])
                    ->columnSpan(3),

                Forms\Components\TextInput::make('price')
                    ->label('Stand Price')
                    ->columnSpan(3),


                Forms\Components\RichEditor::make('description')
                    ->label('Stand Description')
                    ->columnSpanFull(),



            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.first_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('stand_number')->sortable()->label('Stand No')->searchable(),
                Tables\Columns\TextColumn::make('square_metres')->sortable()->label('Size')->suffix('sqm')->searchable(),
                Tables\Columns\TextColumn::make('is_taken')->sortable()
                    ->label('Availability')
                    ->formatStateUsing(fn ($state) => $state ? 'Taken' : 'Available')
                    ->badge()
                    ->color(fn ($state) => $state ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('price')->prefix('$'),
                Tables\Columns\TextColumn::make('amount_paid')->prefix('$'),
                Tables\Columns\TextColumn::make('balance')->prefix('$'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])->headerActions([
                ImportAction::make()
                    ->importer(StandImporter::class)
                    ->label('Import Stands')
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
            'index' => Pages\ListStands::route('/'),
            'create' => Pages\CreateStand::route('/create'),
            'edit' => Pages\EditStand::route('/{record}/edit'),
        ];
    }
}
