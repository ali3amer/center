<div>
    <x-container title="التحويلات">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-4">
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="transfer_type" :live="true" :options="$transfer_types" label="نوع العملية"/>
                <x-select name="bank_id" :disabled="empty($banks)" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" label="رقم العملية"/>
            </div>
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" :live="true" label="المبلغ"/>
                <x-input name="note" label="ملاحظات"/>
                <x-button model="transfers" :disabled="$disabled" type="submit" label="حفظ"/>
            </div>
        </form>
    </x-container>
    <x-container>
        <x-table :headers="$headers" model="transfers" :rows="$transfers" :$numbers :search="false" :cells="$cells"/>
    </x-container>
</div>
