<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="arabic_name" :disabled="$batchMode" width="1/3" label="الإسم بالعربي"/>
            <x-input name="english_name" :disabled="$batchMode" width="1/3" label="الإسم بالانجليزي"/>
            <x-select name="gender" :disabled="$batchMode" width="1/3" :options="$genders" label="الجنس"/>
            <x-input name="phone" :disabled="$batchMode" width="1/3" label="الهاتف"/>
            <x-input name="email" :disabled="$batchMode" width="1/3" label="البريد الالكتروني"/>

            @if(!$batchMode)
                <x-button type="submit" width="1/3" label="حفظ"/>
            @else
                <x-button type="button" color="bg-red-600" wire:click="$toggle('batchMode')" width="1/4" label=""
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
