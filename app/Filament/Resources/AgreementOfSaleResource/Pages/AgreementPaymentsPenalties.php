<?php

namespace App\Filament\Resources\AgreementOfSaleResource\Pages;

use App\Filament\Resources\AgreementOfSaleResource;
use App\Models\AgreementOfSale;
use App\Models\Installment;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class AgreementPaymentsPenalties extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    public $selectedPaymentId;

    protected static string $resource = AgreementOfSaleResource::class;
    protected static ?string $navigationLabel = 'Penalties';
    protected static ?string $navigationIcon = 'penalt';

    protected static string $view = 'filament.resources.agreement-of-sale-resource.pages.agreement-payments-penalties';

    public function table(Table $table): Table
    {

        $aggrement = AgreementOfSale::find($this->record->id);


        return $table
            ->query(
                Installment::query()
                    ->where('agreement_of_sale_id', $this->record->id)
                    ->whereNotNull('penalty')// Assuming $this->record is the current AgreementOfSale instance
            )
            ->columns([
                TextColumn::make('generated_for_year')
                    ->label('Penalty for(Month Year)')
                    ->searchable(['year', 'month'])
                    ->sortable()
                    ->getStateUsing(fn ($record) => date('M', mktime(0, 0, 0, $record->month, 10))  . '-' . $record->year),

                TextColumn::make('penalty')->prefix('$'),
            ])
            ->actions([
                    ViewAction::make('Add Payment')
                        ->icon('payments')
                        ->label('Payment')
                        ->form([])
                        ->button()
                        ->slideOver(),
            ]);
    }


}
