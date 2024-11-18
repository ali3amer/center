<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="name" label="الإسم" />
            <x-input name="phone" label="الهاتف" />
            <x-input name="email" label="البريد الالكتروني" />
            <x-input name="position" label="الوظيفة" />
            <x-input name="salary" label="المرتب" />
            <x-button type="submit"  label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$employees" :cells="$cells" />
    </x-container>
</div>
