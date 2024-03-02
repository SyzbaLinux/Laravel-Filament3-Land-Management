<x-filament-panels::page>
    @livewire(\App\Filament\Resources\AgreementOfSaleResource\Widgets\PaymentsChart::class, ['agreement_id'=>$this->record->id])
    {{ $this->table }}
</x-filament-panels::page>
