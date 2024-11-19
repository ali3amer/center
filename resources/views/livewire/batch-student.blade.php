<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-select name="batch_id" :disabled="$batchStudentPaymentMode" :options="$batches" label="الدفعه"/>
            <x-input type="date" name="date" :disabled="$batchStudentPaymentMode" label="تاريخ التسجيل"/>
            @if(!$batchStudentPaymentMode)
                <x-button type="submit" :center="true" label="حفظ"/>
            @else
                <x-button type="button" color="bg-red-600" wire:click="resetData" width="1/4" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$batchStudentPaymentMode)
        <x-container>
            <x-table :headers="$headers" :rows="$batchStudents" :cells="$cells" :choose="true"/>
        </x-container>
    @else
        <livewire:employee-expense :$employee_id />
    @endif


</div>
