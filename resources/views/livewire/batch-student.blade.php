<div>
    <x-container  title="البرامج التدريبيه للدارس">
        <form wire:submit="save">
            <div  class="grid gap-x-1 grid-cols-4">
                <x-select name="batch_id" :disabled="$batchStudentPaymentMode" :live="true" :options="$batches" label="الدفعه"/>
                <x-input type="date" name="date" :disabled="$batchStudentPaymentMode" label="تاريخ التسجيل"/>
                <x-input name="price" :disabled="true" label="المطلوب"/>
                <x-input name="remainder" :disabled="true" label="المتبقي"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-checkbox name="want_certification" :live="true" :disabled="$batchStudentPaymentMode || $paid" label="هل ترغب في شهاده"/>
                <x-input name="student_number" :disabled="$batchStudentPaymentMode" label="رقم الطالب"/>
                <x-input name="certification_id" :disabled="$batchStudentPaymentMode" label="رقم الشهادة"/>
                @if(!$batchStudentPaymentMode)
                    <x-button model="batchStudents" type="submit" :center="true" label="حفظ"/>
                @else
                    <x-button model="batchStudents" type="button" color="bg-red-600" wire:click="resetData" label=""
                              icon="fa-close"/>
                @endif
            </div>
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
