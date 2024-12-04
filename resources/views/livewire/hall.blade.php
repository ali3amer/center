<div>
    <x-container  title="القاعات">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-4">
            <x-input name="name" :disabled="$rentalMode" label="الإسم" />
            <x-input name="chairs" :disabled="$rentalMode" label="عدد الكراسي" />
            <x-input name="price" :disabled="$rentalMode" label="السعر" />

            @if(!$rentalMode)
                <x-button type="submit" :center="true" label="حفظ" />
            @else
                <x-button type="button" color="bg-red-600" wire:click="resetData" label=""
                          icon="fa-close"/>
            @endif

        </form>
    </x-container>

    @if(!$rentalMode)
        <x-container>
            <x-table :headers="$headers" :rows="$halls" :choose="true" :cells="$cells" />
        </x-container>
    @else
        <livewire:hall-rental :$hall_id />
    @endif
</div>
