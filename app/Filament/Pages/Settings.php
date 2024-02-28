<?php

namespace App\Filament\Pages;

use App\Models\Setting; // Adjust this namespace based on your actual Setting model
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Actions\Action;


class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.setting';

    // Assuming you store only one setting record, you can fetch the first one
    // or create a new instance if it doesn't exist.

    public Setting $record;

    public function mount(): void
    {
        $this->record = Setting::firstOrCreate([
            'company_name' => 'Default',
            'address' => 'Default',
            'email' => 'Default',
        ]);
        $this->form->fill($this->record->toArray());
    }



    public function  form(Form $form): Form
    {
          return  $form->schema([
              Forms\Components\TextInput::make('company_name')
                  ->required(),
              Forms\Components\TextInput::make('address')
                  ->required(),
              Forms\Components\TextInput::make('email')
                  ->email()
                  ->required(),
              Forms\Components\FileUpload::make('logo')
                  ->image()
                  ->directory('logos'),
              Forms\Components\TextInput::make('vendor_number'),
              Forms\Components\TextInput::make('bpn_number'),
              Forms\Components\TextInput::make('tax_number'),
              Forms\Components\TextInput::make('landline_1'),
              Forms\Components\TextInput::make('landline_2'),
              Forms\Components\TextInput::make('mobile_1'),
              Forms\Components\TextInput::make('mobile_2'),
              Forms\Components\TextInput::make('website')->url(),


          ])->columns(3);
    }


    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updateSettingsAction')
                ->label('Update Settings')
                ->action(function(){$this->saveSettings(); } ),
        ];
    }

    public function saveSettings(): void
    {
        $validatedData = $this->form->getState();

        dd($validatedData);
        $this->record->update($validatedData);

        $this->notify('success', 'Settings saved successfully.');
    }
}

