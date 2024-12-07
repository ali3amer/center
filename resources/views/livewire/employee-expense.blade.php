<div>
    <x-container title="مدفوعات الموظف">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" :live="true" label="المبلغ"/>
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="type" :options="$types" label="نوع العملية"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-select name="payment_method" :options="$payment_methods" label="وسيلة الدفع"/>
                <x-select name="bank_id" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" label="رقم الاشعار"/>
                <x-button type="submit" :disabled="floatval($amount) == 0" model="employeeExpenses"  label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" model="employeeExpenses" :rows="$employeeExpenses" :search="false" :cells="$cells"/>
    </x-container>
</div>
