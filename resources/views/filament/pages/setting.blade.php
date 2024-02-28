<x-filament-panels::page>
    <x-filament-panels::form>
        {{ $this->form }}
        <x-filament-panels::form.actions
            :actions="$this->getUpdatePasswordFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
