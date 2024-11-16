<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="name" width="1/3" label="الإسم" />
            <x-input name="phone" width="1/3" label="الهاتف" />
            <x-input name="email" width="1/3" label="البريد الالكتروني" />
            <x-input name="position" width="1/3" label="الوظيفة" />
            <x-input name="salary" width="1/3" label="المرتب" />
            <x-button type="submit"  width="1/3" label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$employees" :cells="$cells" />
    </x-container>
</div>
