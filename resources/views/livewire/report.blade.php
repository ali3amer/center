<div>

    <x-container title="التقارير">
        <form wire:submit="getReport"
              class="grid gap-x-1 grid-cols-{{ $type == 'certifications' ||$type == 'performance' || $type == 'courses' ? '6' : '4' }}">

            <x-select name="type" wire:change="resetData" :options="$types" :live="true" label="نوع التقرير"/>
            @if($type == 'certifications' ||$type == 'performance' || $type == 'courses')
                <x-select name="report_type" wire:change="resetData" :live="true"  :options="$report_types" label="بالمدرب ام بالبرنامج"/>
                @if($report_type == "course")
                    <x-select name="course_id" :options="$courses" label="البرنامج التدريبي"/>
                @else
                    <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
                @endif
            @endif
            <x-input type="date" name="from" label="من تاريخ"/>
            <x-input type="date" name="to" label="الى تاريخ"/>
            <x-button type="submit" model="reports" :center="true" :disabled="$type == null" label="جلب التقرير"/>
        </form>
    </x-container>

    <div>
        <header class="hidden print:block">a</header>
        @if(!empty($rows))
            @if($type != 'expenses')

                <x-container>
                    <x-button width="1/12" type="button" model="reports" @click="$('.report').printThis()" :center="true"
                              :disabled="$type == null" label="طباعه"/>
                    @if($type == 'safe')
                        <div class="flex report" style="direction: rtl">
                            <x-input name="balance" :disabled="true" width="1/4" label="الرصيد"
                                     value="{{ $incomes - $expenses }}"/>
                        </div>
                    @endif
                    <div class="report" style="direction: rtl">
                        <x-table class="report" :headers="$headers" :$numbers :array="true" :footers="$footers" :search="false"
                                 model="reports"
                                 :buttons="false"
                                 :index="$type == 'safe' ? false : true" :rows="$rows" :paginate="false" :cells="$cells"/>
                    </div>
                </x-container>

            @else
                @if(isset($headers['options']))
                    <x-container>
                        <div class="report">
                            <x-table class="report" :headers="$headers['options']" :numbers="$numbers['options']"
                                     :footers="$footers['options']" model="reports" :array="true" :search="false"
                                     :buttons="false"
                                     :index="$type == 'safe' ? false : true" :rows="$rows['options']" :paginate="false"
                                     :cells="$cells['options']"/>
                        </div>
                    </x-container>

                    <x-container>
                        <div class="report">
                            <x-table class="report" :headers="$headers['expenses']" :expenses="true" :numbers="$numbers['expenses']"
                                     :footers="$footers['expenses']" model="reports" :array="true" :search="false"
                                     :buttons="false"
                                     :rows="$rows['expenses']" :paginate="false"
                                     :cells="$cells['expenses']"/>
                        </div>
                    </x-container>
                @endif
            @endif
        @endif
    </div>
</div>
