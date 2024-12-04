<div>
    <x-container title="الدارسين">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="arabic_name" :disabled="$batchMode" label="الإسم بالعربي"/>
            <x-input name="english_name" :disabled="$batchMode" label="الإسم بالانجليزي"/>
            <x-select name="gender" :disabled="$batchMode" :options="$genders" label="الجنس"/>
            <x-input name="phone" :disabled="$batchMode" label="الهاتف"/>
            <x-input name="email" :disabled="$batchMode" label="البريد الالكتروني"/>

            @if(!$batchMode)
                <x-button type="submit" label="حفظ"/>
            @else
                <x-button type="button" color="bg-red-600" wire:click="resetData" width="1/4" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$batchMode)
        <x-container>
            <x-table :headers="$headers" :rows="$students" :choose="true" :cells="$cells"/>
        </x-container>
    @else
        <livewire:batch-student :$student_id />
    @endif
</div>
