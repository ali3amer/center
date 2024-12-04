<div>
    @if($trainerPaymentMode)
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
    @endif

    @if(!$trainerPaymentMode)
        <x-container  title="البرامج التدريبيه للمدرب">
            <x-table :headers="$headers" :rows="$batches" :edit="false" :delete="false" :choose="true" :cells="$cells"/>
        </x-container>
    @else
        <livewire:trainer-payment :$batch_id />
    @endif
</div>
