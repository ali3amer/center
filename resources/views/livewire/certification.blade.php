<div>
    @if(!empty($course))
        <x-container>
            <span wire:click="resetCourse">{{ $course['arabic_name'] }}</span>  <span wire:click="resetBatch">{{ !empty($batch) ? ' / ' . $batch['start_date'] : '' }}</span>
        </x-container>
    @endif
    <x-container>
        <x-table :headers="$headers" :rows="$rows" :edit="false" :delete="false" :model="$key" :buttons="$key == 'batchStudents' ? false : true" :functions="[$functions[$key]]" :cells="$cells"/>
    </x-container>
</div>
