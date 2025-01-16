<div>
    <x-container>
        <form wire:submit="editSafe" class="grid gap-x-1 grid-cols-5">
            <x-input name="initial_balance" label="الرصيد الافتتاحي"/>
            <x-input type="date" name="date" label="التاريخ"/>
            <x-button model="settings" type="submit" :center="true" label="حفظ"/>
            <x-button model="settings" type="button" :center="true" wire:click="dbBackup" icon="fa-download" label=""/>
            <x-button model="settings" type="button" :center="true" wire:click="getFromExcel" label="سحب بيانات"/>
        </form>


    </x-container>
</div>
