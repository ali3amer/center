<div>
    <x-container>
        <form wire:submit="save" class="flex">
            <x-input name="name" width="1/6" label="الإسم" />
            <x-input name="phone" width="1/6" label="الهاتف" />
            <x-input name="email" width="1/6" label="الايميل" />
            <x-input name="position" width="1/6" label="الوظيفة" />
            <x-input name="salary" width="1/6" label="المرتب" />
            <x-button type="submit"  label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$employees->toArray()" :cells="$cells" />
    </x-container>
</div>
