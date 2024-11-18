<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-4">
            <x-input name="name" :disabled="$rentalMode" width="1/4" label="الإسم" />
            <x-input name="chairs" :disabled="$rentalMode" width="1/4" label="عدد الكراسي" />
            <x-input name="price" :disabled="$rentalMode" width="1/4" label="السعر" />

            @if(!$rentalMode)
                <x-button type="submit" :center="true" width="1/4" label="حفظ" />
            @else
                <x-button type="button" color="bg-red-600" wire:click="resetData" width="1/4" label=""
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
