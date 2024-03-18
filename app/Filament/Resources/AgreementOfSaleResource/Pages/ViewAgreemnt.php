<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Models\Partner;
use App\Models\Stand;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Alignment;
use Filament\Forms;
use Filament\Forms\Form;

class ViewAgreemnt extends ViewRecord
{

    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $title = 'Details';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.view-agreement';


    public function getHeaderActions(): array
    {

        return [

            CreateAction::make('addStand')
                ->label('Add Stand')
                ->model(Stand::class)
                ->form([
                    Forms\Components\Section::make()->schema([

                        Forms\Components\Hidden::make('project_id')->default(Filament::getTenant()->id),
                        Forms\Components\Hidden::make('is_taken')->default(true),
                        Forms\Components\Hidden::make('client_id')->default($this->record->client_id),
                        Forms\Components\Hidden::make('agreement_of_sale_id')->default($this->record->id),


                        Forms\Components\TextInput::make('stand_number')
                            ->label('Stand No')
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('square_metres')
                            ->label('Stand Square Metres')
                            ->numeric()
                            ->default(300)
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('price')
                            ->label('Stand Price')
                            ->numeric()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('electrification_costs')
                            ->label('Other Costs')
                            ->numeric()
                            ->columnSpan(3),

                    ])->columns(12)
                ]) ,

            CreateAction::make('addPartner')
                ->label('Add Partner to Contact')
                ->model(Partner::class)
                ->form([

                   Forms\Components\Section::make()->schema([

                       Forms\Components\Hidden::make('stand_id')
                           ->default($this->record->stand_id),

                       Forms\Components\Hidden::make('project_id')
                           ->default(Filament::getTenant()->id),

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

                ])
                ->slideOver(),
        ];
    }
}
