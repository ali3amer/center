<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="arabic_name" width="1/3" label="الإسم بالعربي"  />
            <x-input name="english_name" width="1/3" label="الإسم بالانجليزي"  />
            <x-select name="type" width="1/3" :options="$types" label="نوع البرنامج" />
            <x-input name="price" width="1/4" label="السعر"  />
            <x-select name="duration" width="1/4" :options="$durations" label="نوع المده"  />
            <x-input name="duration_value" width="1/3" label="المده"  />
            <x-button type="submit" label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$courses" :cells="$cells" />
    </x-container>
</div>
