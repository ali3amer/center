<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="arabic_name" width="1/3" label="الإسم بالعربي"  />
            <x-input name="english_name" width="1/3" label="الإسم بالانجليزي"  />
            <x-select name="gender" width="1/3" :options="$genders" label="الجنس" />
            <x-input name="phone" width="1/3" label="الهاتف"  />
            <x-input name="email" width="1/3" label="البريد الالكتروني"  />

            <x-button type="submit" width="1/3" label="حفظ" />
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$trainers" :cells="$cells" />
    </x-container>
</div>
