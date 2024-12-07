<div>
    <x-container title="تصنيفات المصروفات">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-4">
            <x-input name="optionName" label="التصنيف"/>
            <div class="grid gap-x-1 grid-cols-2">
                <x-button type="submit" model="expenseOptions" :center="true" label="حفظ"/>
                <x-button model="expenses" permission="read" wire:click="$parent.$toggle('optionMode')" :center="true" class="bg-yellow-500" icon="fa-list"
                          label=""/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" model="expenseOptions" :rows="$expense_options" :cells="$cells"/>
    </x-container>
</div>
