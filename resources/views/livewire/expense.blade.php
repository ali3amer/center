<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="description" width="1/4" label="البيان" />
            <x-input name="amount" width="1/4" label="المبلغ" />
            <x-input name="date" type="date" width="1/4" label="التاريخ" />
            <x-button type="submit" width="1/4" label="حفظ" />

        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$expenses" :cells="$cells" />
    </x-container>
</div>
