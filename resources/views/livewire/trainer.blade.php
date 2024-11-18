<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="arabic_name" label="الإسم بالعربي"  />
            <x-input name="english_name" label="الإسم بالانجليزي"  />
            <x-select name="gender" :options="$genders" label="الجنس" />
            <x-input name="phone" label="الهاتف"  />
            <x-input name="email" label="البريد الالكتروني"  />
            <x-button type="submit" label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$trainers" :cells="$cells" />
    </x-container>
</div>
