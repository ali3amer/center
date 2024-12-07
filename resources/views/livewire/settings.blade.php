<div>
    <x-container>
        <form wire:submit="editSafe" class="grid gap-x-1 grid-cols-4">
            <x-input name="initial_balance" label="الرصيد الافتتاحي"/>
            <x-input name="date" label="التاريخ"/>
            <x-button model="settings" type="submit" :center="true" label="حفظ"/>
        </form>
    </x-container>
</div>
