<div>
    <x-container  title="البرامج التدريبيه للدارس">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-6">
            <x-select name="batch_id" :disabled="$batchStudentPaymentMode" :live="true" :options="$batches" label="الدفعه"/>
            <x-input type="date" name="date" :disabled="$batchStudentPaymentMode" label="تاريخ التسجيل"/>
            <x-checkbox name="want_certification" :disabled="$batchStudentPaymentMode || $paid" label="هل ترغب في شهاده"/>
            <x-input name="price" :disabled="true" label="المطلوب"/>
            <x-input name="remainder" :disabled="true" label="المتبقي"/>
            @if(!$batchStudentPaymentMode)
                <x-button model="batchStudents" type="submit" :center="true" label="حفظ"/>
            @else
                <x-button model="batchStudents" type="button" color="bg-red-600" wire:click="resetData" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$batchStudentPaymentMode)
        <x-container>
            <x-table :headers="$headers" model="batchStudents" chooseModel="batchStudentPayments" :rows="$batchStudents" :cells="$cells" :choose="true"/>
        </x-container>
    @else
        <livewire:batch-student-payment :$batch_student_id />
    @endif


</div>
