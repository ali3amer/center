<div>
    <x-container>
        <button wire:click="redirectToPdf" class="btn btn-primary">Download PDF</button>
    </x-container>
    <x-container title="التقارير">
        <form wire:submit="getReport" class="grid gap-x-1 grid-cols-{{ $type == 'certifications' ? '5' : '4' }}">
            <x-select name="type" :options="$types" :live="true" label="نوع التقرير"/>
            @if($type == 'certifications')
                <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
            @endif
            <x-input type="date" name="from" label="من تاريخ"/>
            <x-input type="date" name="to" label="الى تاريخ"/>
            <x-button type="submit" model="reports" :center="true" label="جلب التقرير"/>
        </form>
    </x-container>

    @if(!empty($rows))
        @if($type != 'expenses')
            <x-container>
                <x-table :headers="$headers" :search="false" model="reports" :buttons="false"
                         :index="$type == 'safe' ? false : true" :rows="$rows" :paginate="false" :cells="$cells"/>
            </x-container>

        @else
            <x-container>
                <x-table :headers="$headers['options']" model="reports" :array="true" :search="false" :buttons="false"
                         :index="$type == 'safe' ? false : true" :rows="$rows['options']" :paginate="false"
                         :cells="$cells['options']"/>
            </x-container>

            <x-container>
                <x-table :headers="$headers['expenses']" model="reports" :array="true" :search="false" :buttons="false"
                         :index="$type == 'safe' ? false : true" :rows="$rows['expenses']" :paginate="false"
                         :cells="$cells['expenses']"/>
            </x-container>
        @endif
    @endif
</div>
