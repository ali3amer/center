<div>

    @if(!$trainerPaymentMode)
        <x-container  title="البرامج التدريبيه للمدرب">
            <x-table :headers="$headers" model="trainerBatches" chooseModel="trainerBatches" :rows="$batches" chooseText="مدفوعات المدرب"  :edit="false" :delete="false" :choose="true" :cells="$cells"/>
        </x-container>
    @else
        <livewire:trainer-payment :$batch_id />
    @endif
</div>
