<div>
    <x-container>
        <div class="grid gap-x-1 grid-cols-4">
            <x-select name="course_id" :live="true" wire:change="chooseCourse" :options="$courses"
                      label="البرامج التدريبية"/>
            <x-select name="batch_id" :live="true" wire:change="chooseBatch" :options="$batches"
                      label="الدفعات"/>
            @if(!$batchCertificationPayments)
                <x-button model="batchStudents" wire:click="$set('batchCertificationPayments', true)" :center="true" label="مدفوعات الشهادات"/>
            @else
                <x-button model="batchStudents" type="button" color="bg-red-600" wire:click="resetData" label=""
                          icon="fa-close"/>
            @endif
        </div>
    </x-container>
    @if(!$batchCertificationPayments)
        <x-container>
            <x-table :headers="$headers" :rows="$certifications" :edit="false" :paginate="false" :delete="false"
                     :buttons="false" :cells="$cells"/>
        </x-container>
    @else
        <livewire:batch-certification-payment :$batch_id />
    @endif
</div>
