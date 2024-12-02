<div>
    @if(!$optionMode)
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-5">
            <x-input name="description" label="البيان" />
            <x-select name="expense_option_id" :options="$options" label="التصنيف"/>
            <x-input name="amount" label="المبلغ" />
            <x-input name="date" type="date" label="التاريخ" />
            <div class="grid gap-x-1 grid-cols-2">
                <x-button type="submit" :center="true" label="حفظ"/>
                <x-button wire:click="$toggle('optionMode')" :center="true" class="bg-yellow-500" icon="fa-list" label=""/>
            </div>
        </form>
    </x-container>

        <x-container>
            <x-table :headers="$headers" :rows="$expenses" :cells="$cells" />
        </x-container>
    @else
        <livewire:expense-option />
    @endif
</div>
