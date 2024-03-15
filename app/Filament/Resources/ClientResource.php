<?php

namespace App\Filament\Resources;

use App\Filament\Imports\ClientImporter;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ImportAction;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'tenants';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'List Clients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Tenant Details')->schema([


                    Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->columnSpan(4),

                    Forms\Components\TextInput::make('middle_name')
                        ->columnSpan(4),

                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->columnSpan(4),

                    Forms\Components\TextInput::make('email')
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('phone')
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('natID')
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('tax_number')
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('bpn_number')
                        ->columnSpan(3),

                    Forms\Components\Textarea::make('address')
                        ->columnSpan(6),

                ])->columns(12)

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
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('natID')->label('NatID')->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(ClientImporter::class)
                    ->label('Import Clients')
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
