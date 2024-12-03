<div>
    <x-container>
        <form wire:submit="getReport" class="grid gap-x-1 grid-cols-{{ $type == 'certifications' ? '5' : '4' }}">
            <x-select name="type" :options="$types" :live="true" label="نوع التقرير"/>
            @if($type == 'certifications')
                <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
            @endif
            <x-input type="date" name="from" label="من تاريخ"/>
            <x-input type="date" name="to" label="الى تاريخ"/>
            <x-button type="submit" :center="true" label="جلب التقرير"/>
        </form>
    </x-container>

        @if(!empty($rows))
        <x-container>
            <x-table :headers="$headers" :buttons="false" :index="true" :rows="$rows" :paginate="false" :cells="$cells"/>
        </x-container>
        @endif
</div>
