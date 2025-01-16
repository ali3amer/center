<div>
    <x-container title="الدارسين">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="arabic_name" :disabled="$batchMode" label="الإسم بالعربي"/>
            <x-input name="english_name" :disabled="$batchMode" label="الإسم بالانجليزي"/>
            <x-select name="gender" :disabled="$batchMode" :options="$genders" label="الجنس"/>
            <x-input name="phone" :disabled="$batchMode" label="الهاتف"/>
            <x-input name="email" :disabled="$batchMode" label="البريد الالكتروني"/>

            @if(!$batchMode)
                <x-button type="submit" model="students" label="حفظ"/>
            @else
                <x-button type="button" model="students" color="bg-red-600" wire:click="resetData" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$batchMode)
        <x-container>
            <x-table :headers="$headers" model="students" chooseModel="batchStudents" :rows="$students" chooseText="الدفعات"  :choose="true" :cells="$cells"/>
        </x-container>
    @else
        <livewire:batch-student :$student_id />
    @endif
</div>
