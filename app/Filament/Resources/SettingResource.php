<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function form(Form $form): Form
    {
        return $form
                 ->schema([
                     Forms\Components\TextInput::make('company_name')
                         ->required(),
                     Forms\Components\Textarea::make('address')
                         ->required(),
                     Forms\Components\TextInput::make('email')
                         ->email()
                         ->required(),
                     Forms\Components\FileUpload::make('logo')
                         ->disk('public')
                         ->directory('logos')
                         ->image(),
                     Forms\Components\TextInput::make('vendor_number'),
                     Forms\Components\TextInput::make('bpn_number'),
                     Forms\Components\TextInput::make('tax_number'),
                     Forms\Components\TextInput::make('landline_1'),
                     Forms\Components\TextInput::make('landline_2'),
                     Forms\Components\TextInput::make('mobile_1'),
                     Forms\Components\TextInput::make('mobile_2'),
                     Forms\Components\TextInput::make('website'),
                 ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('company_name')
            ])
            ->paginated(false);
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
