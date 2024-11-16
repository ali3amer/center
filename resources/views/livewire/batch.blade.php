<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-select name="trainer_id" width="1/4" :options="$trainers" label="المدرب"/>
            <x-input type="date" name="start_date" width="1/4" label="تاريخ البدايه"/>
            <x-input type="date" name="end_date" width="1/4" label="تاريخ النهايه"/>
            <x-button type="submit" width="1/4" label="حفظ"/>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$batches" :search="false" :cells="$cells" />
    </x-container>
</div>
