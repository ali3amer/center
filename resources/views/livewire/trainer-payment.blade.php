<div>

    <x-container>
        <div class="grid gap-x-1 grid-cols-5">
            <x-input name="price" :disabled="true" label="السعر"/>
            <x-input name="studentCount" :disabled="true" label="عدد الدارسين"/>
            <x-input name="cost" :disabled="true" label="الجمله"/>
            <x-input name="center_fees" :disabled="true" label="نصيب المركز %"/>
            <x-input name="trainer_fees" :disabled="true" label="نصيب المدرب %"/>
        </div>
        <div class="grid gap-x-1 grid-cols-6">
            <x-input name="certificate_price" :disabled="true" :live="true" label="سعر الشهادة"/>
            <x-input name="certificate_cost" :disabled="true" :live="true" label="تكلفة الشهادات"/>
            <x-input name="required" :live="true" :disabled="true" label="المطلوب"/>
            <x-input name="paid" :live="true" :disabled="true" label="المدفوع"/>
            <x-input name="remainder" :live="true" :disabled="true" label="المتبقي"/>
            <x-button type="button" color="bg-red-600" wire:click="resetData" label=""
                      icon="fa-close"/>
        </div>
    </x-container>

    <x-container title="مدفوعات للمدرب">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="amount" label="المبلغ" :live="true"/>
                <x-input type="date" name="date" label="التاريخ"/>
                <x-select name="payment_method" :options="$payment_methods" label="وسيلة الدفع"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-select name="bank_id" :options="$banks" label="البنك"/>
                <x-input name="transaction_id" label="رقم الاشعار"/>
                <x-input name="note" label="ملاحظات"/>
                <x-button type="submit"
                          :disabled="$remainder <= 0 || floatval($amount) == 0 || floatval($amount) > $remainder"
                          :center="true" label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$batchTrainerPayments" :search="false" :cells="$cells"/>
    </x-container>
</div>
