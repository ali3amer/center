<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-5">
            <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
            <x-input type="date" name="start_date" label="تاريخ البدايه"/>
            <x-input type="date" name="end_date" label="تاريخ النهايه"/>
            <x-checkbox name="completed" label="مكتمل" />
            <x-button type="submit" label="حفظ"/>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$batches" :search="false" :cells="$cells" />
    </x-container>
</div>
