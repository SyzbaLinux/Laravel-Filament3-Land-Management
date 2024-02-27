<?php

namespace App\Filament\Pages;

use App\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Support\Str;

class EditProjectProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Project Details';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state)) )
                ,

                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(Property::class, 'slug', ignoreRecord: true),
                Textarea::make('address')->rows(3)->columnSpanFull(),
            ]);
    }
}
