<div>
    <x-container title="الدفعه">
        <form wire:submit="save" class="">
            <div class="grid gap-x-1 grid-cols-5">
                <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
                <x-input name="price" wire:keyup="calc" label="السعر" />
                <x-input name="center_fees" label="نصيب المركز %" />
                <x-input name="trainer_fees" label="نصيب المدرب %" />
                <x-checkbox name="paid" label="مدفوع" />
            </div>
            <div class="grid gap-x-1 grid-cols-5">
                <x-input name="certificate_price" wire:keyup="calc" :live="true" label="سعر الشهادة" />
                <x-input type="date" name="start_date" label="تاريخ البدايه"/>
                <x-input type="date" name="end_date" label="تاريخ النهايه"/>
                <x-input name="fees" :disabled="true" label="الصافي"/>
                <x-button type="submit" model="batches" label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$batches" :$functions :$numbers model="batches" :search="false" :cells="$cells" />
    </x-container>
</div>
