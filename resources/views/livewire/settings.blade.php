<div>
    <x-container>
        <form wire:submit="editSafe" class="grid gap-x-1 grid-cols-4">
            <x-input name="initial_balance" label="الرصيد الافتتاحي"/>
            <x-input name="date" label="التاريخ"/>
            <x-button model="settings" type="submit" :center="true" label="حفظ"/>
            <x-button model="settings" type="button" :center="true" wire:click="dbBackup" icon="fa-download" label=""/>
        </form>
    </x-container>
</div>
