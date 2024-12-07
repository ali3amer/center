<div>
    <x-container  title="مدفوعات الدارس">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" :live="true" label="المبلغ"/>
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="payment_method" :options="$payment_methods" label="وسيلة الدفع"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-select name="bank_id" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" label="رقم الاشعار"/>
                <x-input name="note" label="ملاحظات"/>
                <x-button type="submit" model="batchStudentPayments" :disabled="$remainder <= 0 || floatval($amount) == 0 || floatval($amount) > $remainder" :center="true" label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" model="batchStudentPayments" :rows="$batchStudentPayments" :search="false" :cells="$cells"/>
    </x-container>
</div>
