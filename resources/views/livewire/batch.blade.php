<div>
    <x-container>
        <form wire:submit="save" class="">
            <div class="grid gap-x-1 grid-cols-6">
                <x-select name="trainer_id" :options="$trainers" label="المدرب"/>
                <x-input name="price" :live="true" label="السعر" />
                <x-input name="center_fees" label="نصيب المركز %" />
                <x-input name="trainer_fees" label="نصيب المدرب %" />
                <x-checkbox name="paid" label="مدفوع" />
                <x-input name="certificate_price" :live="true" label="سعر الشهادة" />
            </div>
            <div class="grid gap-x-1 grid-cols-5">
                <x-input type="date" name="start_date" label="تاريخ البدايه"/>
                <x-input type="date" name="end_date" label="تاريخ النهايه"/>
                <x-checkbox name="completed" label="مكتمل" />
                <x-input name="fees" :live="true" :disabled="true" label="الصافي"/>
                <x-button type="submit" label="حفظ"/>
            </div>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$batches" :search="false" :cells="$cells" />
    </x-container>
</div>
