<div>
    <x-container title="مدفوعات الموظف">
        <div class="flex">
            <x-input name="balance" :disabled="true" :live="true" width="1/4" label="الرصيد"/>
        </div>
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" :live="true" label="المبلغ"/>
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="type" :options="$types" label="نوع العملية"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-select name="payment_method" :disabled="$payment_method == 'bank' && empty($banks)" :live="true" :options="$payment_methods" label="وسيلة الدفع"/>
                <x-select name="bank_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" label="رقم الاشعار"/>
{{--                <x-button type="submit" :disabled="floatval($amount) == 0 || (floatval($amount) > session($payment_method.'_balance'))" model="employeeExpenses"  label="حفظ"/>--}}
                <x-button type="submit" :disabled="floatval($amount) == 0" model="employeeExpenses"  label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" model="employeeExpenses" :$numbers :rows="$employeeExpenses" :search="false" :cells="$cells"/>
    </x-container>
</div>
