<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-start">
            <x-filament::button type="submit" icon="heroicon-m-check" size="lg">
                Simpan Pengaturan
            </x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</x-filament-panels::page>
