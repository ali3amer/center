<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-4">
            <x-input name="description" label="البيان" />
            <x-input name="amount" label="المبلغ" />
            <x-input name="date" type="date" label="التاريخ" />
            <x-button type="submit" :center="true" label="حفظ" />

        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$expenses" :cells="$cells" />
    </x-container>
</div>
