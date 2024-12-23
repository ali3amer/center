<div>

    <x-container title="التقارير">
        <form wire:submit="getReport" class="grid gap-x-1 grid-cols-{{ $type == 'certifications' ||$type == 'performance' || $type == 'courses' ? '5' : '4' }}">
            <x-select name="type" wire:change="resetData" :options="$types" :live="true" label="نوع التقرير"/>
            @if($type == 'certifications' ||$type == 'performance' || $type == 'courses')
                <x-select name="trainer_id" :options="$courses" label="البرنامج التدريبي"/>
            @endif
            <x-input type="date" name="from" label="من تاريخ"/>
            <x-input type="date" name="to" label="الى تاريخ"/>
            <x-button type="submit" model="reports" :center="true" label="جلب التقرير"/>
        </form>
    </x-container>

    @if(!empty($rows))
        @if($type != 'expenses')

            <x-container>
                @if($type == 'safe')
                    <div class="flex">
                        <x-input name="balance" :disabled="true" width="1/4" label="الرصيد"
                                 value="{{ $incomes - $expenses }}"/>
                    </div>
                @endif
                <x-table :headers="$headers" :$numbers :array="true" :footers="$footers" :search="false" model="reports"
                         :buttons="false"
                         :index="$type == 'safe' ? false : true" :rows="$rows" :paginate="false" :cells="$cells"/>
            </x-container>

        @else
            @if(isset($headers['options']))
                <x-container>
                    <x-table :headers="$headers['options']" :numbers="$numbers['options']" :footers="$footers['options']" model="reports" :array="true" :search="false"
                             :buttons="false"
                             :index="$type == 'safe' ? false : true" :rows="$rows['options']" :paginate="false"
                             :cells="$cells['options']"/>
                </x-container>

                <x-container>
                    <x-table :headers="$headers['expenses']" :expenses="true" :numbers="$numbers['expenses']" :footers="$footers['expenses']" model="reports" :array="true" :search="false"
                             :buttons="false"
                             :rows="$rows['expenses']" :paginate="false"
                             :cells="$cells['expenses']"/>
                </x-container>
            @endif
        @endif
    @endif
</div>
