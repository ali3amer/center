<div>
    <x-container title="التحويلات">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-6">
            <x-input type="date" name="date" label="التاريخ"/>
            <x-select name="transfer_type" :options="$transfer_types" label="نوع العملية"/>
            <x-select name="bank_id" :options="$banks" label="البنك"/>
            <x-input name="transaction_id" label="رقم العملية"/>
            <x-input name="amount" label="المبلغ"/>
            <x-button type="submit" label="حفظ"/>
        </form>
    </x-container>
    <x-container>
        <x-table :headers="$headers" :rows="$transfers" :numbers="['amount']" :search="false" :cells="$cells"/>
    </x-container>
</div>
