<?php

namespace App\Filament\Pages;

use Filament\Forms;
use App\Models\Project;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegisterProject extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Create Project';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>  $set('slug', Str::slug($state))  ),

                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(Project::class, 'slug', ignoreRecord: true),


                Forms\Components\RichEditor::make('description')->columnSpanFull(),

            ]);
    }

    protected function handleRegistration(array $data): Project
    {
        $team = Project::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}
