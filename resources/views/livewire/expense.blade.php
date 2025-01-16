<div>
    @if(!$optionMode)
        <x-container title="المصروفات">
            <form wire:submit="save">
                <div class="grid gap-x-1 grid-cols-5">
                    <x-input name="description" label="البيان"/>
                    <x-select name="expense_option_id" :options="$options" label="التصنيف"/>
                    <x-input name="quantity" :live="true" label="الكمية"/>
                    <x-input name="price" :live="true" label="سعر الوحدة"/>
                    <x-input name="amount" :live="true" :disabled="true" label="المبلغ"/>
                </div>
                <div class="grid gap-x-1 grid-cols-5">
                    <x-input name="date" type="date" label="التاريخ"/>
                    <x-select name="payment_method" :disabled="$payment_method == 'bank' && empty($banks)" :live="true" :options="$payment_methods" label="وسيلة الدفع"/>
                    <x-select name="bank_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" :options="$banks" label="البنك"/>
                    <x-input name="transaction_id" :disabled="$payment_method == 'cash' || ($payment_method == 'bank' && empty($banks))" label="رقم الاشعار"/>
                    <div class="grid gap-x-1 grid-cols-2">
                        <x-button model="expenses" :disabled="floatval($amount) == 0 || (floatval($amount) > session($payment_method.'_balance'))" type="submit" label="حفظ"/>
                        <x-button model="expenseOptions" permission="read" wire:click="$toggle('optionMode')" class="bg-yellow-500"
                                  label="التصنيفات"/>
                    </div>
                </div>
            </form>
        </x-container>

        <x-container>
            <x-table :headers="$headers" model="expenses" :$numbers :rows="$expenses" :cells="$cells"/>
        </x-container>
    @else
        <livewire:expense-option/>
    @endif
</div>
