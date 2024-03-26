<x-filament-panels::page>
    @php
        $installments = \App\Models\Installment::where('agreement_of_sale_id',$this->record->id)->get()
     @endphp


    <div class="container mx-auto bg-white p-3 rounded-xl">

    <h1 class="text-3xl mb-5">Statement of Account</h1>

    @livewire(\App\Filament\Resources\AgreementOfSaleResource\Widgets\StatementWidget::class,['agreement_id'=>$this->record->id])


    </div>
</x-filament-panels::page>
