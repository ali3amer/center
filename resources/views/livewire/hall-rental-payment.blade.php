<div>
    <x-container title="مدفوعات القاعه">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" :live="true" label="المبلغ"/>
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="payment_method" :disabled="$payment_method == 'bank' && empty($banks)" :live="true" :options="$payment_methods" label="وسيلة الدفع"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-select name="bank_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" label="رقم الاشعار"/>
                <x-input name="note" label="ملاحظات"/>
                <x-button type="submit" model="hallRentalPayments" :disabled="($remainder <= 0 || floatval($amount) == 0 || floatval($amount) > $remainder)" :center="true" label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" model="hallRentalPayments" :rows="$hallRentalPayments" :$numbers :search="false" :cells="$cells"/>
    </x-container>
</div>
