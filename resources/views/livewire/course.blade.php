<div>
    <x-container title="البرامج التدريبيه">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-3">
                <x-input name="arabic_name" :disabled="$batchMode" label="الإسم بالعربي"/>
                <x-input name="english_name" :disabled="$batchMode" label="الإسم بالانجليزي"/>
                <x-select name="type" :disabled="$batchMode" :options="$types" label="نوع البرنامج"/>
            </div>
            <div class="grid gap-x-1 grid-cols-4">
                <x-input name="price" :disabled="$batchMode" label="السعر"/>
                <x-select name="duration" :disabled="$batchMode" :options="$durations" label="نوع المده"/>
                <x-input name="duration_value" :disabled="$batchMode" label="المده"/>
                @if(!$batchMode)
                    <x-button model="courses" type="submit" label="حفظ"/>
                @else
                    <x-button model="courses" type="button" color="bg-red-600" wire:click="resetData" label=""
                              icon="fa-close"/>
                @endif
            </div>
        </form>
    </x-container>

    @if(!$batchMode)
        <x-container>
            <x-table :headers="$headers" :rows="$courses" chooseModel="batches" model="courses" chooseText="الدفعات" :cells="$cells" :choose="true"/>
        </x-container>
    @else
        <livewire:batch :$course_id />
    @endif
</div>
