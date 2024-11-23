<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-5">
            <x-input name="bank_name" label="إسم البنك"/>
            <x-input name="name" label="إسم صاحب الحساب"/>
            <x-input name="initial_balance" label="الرصيد الافتتاحي"/>
            <x-input type="date" name="date" label="التاريخ"/>
            <x-button type="submit" label="حفظ"/>
        </form>
    </x-container>
    <x-container>
        <x-table :headers="$headers" :rows="$banks" :search="false" :cells="$cells"/>
    </x-container>
</div>
