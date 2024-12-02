<div>
    <x-container>
        <form wire:submit="getReport" class="grid gap-x-1 grid-cols-4">
            <x-select name="report_type" :options="$types" label="نوع التقرير"/>
            <x-input type="date" name="from" label="من تاريخ"/>
            <x-input type="date" name="to" label="الى تاريخ"/>
            <x-button type="submit" :center="true" label="جلب التقرير"/>
        </form>
    </x-container>

    <x-container>

    </x-container>
</div>
