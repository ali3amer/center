<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="arabic_name" width="1/3" disabled="{{$batchMode}}" label="الإسم بالعربي"/>
            <x-input name="english_name" width="1/3" disabled="{{$batchMode}}" label="الإسم بالانجليزي"/>
            <x-select name="type" width="1/3" disabled="{{$batchMode}}" :options="$types" label="نوع البرنامج"/>
            <x-input name="price" width="1/4" disabled="{{$batchMode}}" label="السعر"/>
            <x-select name="duration" width="1/4" disabled="{{$batchMode}}" :options="$durations" label="نوع المده"/>
            <x-input name="duration_value" width="1/4" disabled="{{$batchMode}}" label="المده"/>
            @if(!$batchMode)
                <x-button type="submit" width="1/4" label="حفظ"/>
            @else
                <x-button type="button" color="bg-red-600" wire:click="$toggle('batchMode')" width="1/4" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$batchMode)
        <x-container>
            <x-table :headers="$headers" :rows="$courses" :cells="$cells" :choose="true"/>
        </x-container>
    @else
        <livewire:batch :$course_id />
    @endif
</div>
