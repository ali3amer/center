<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="name" width="1/4" label="الإسم" />
            <x-input name="chairs" width="1/4" label="عدد الكراسي" />
            <x-input name="price" width="1/4" label="السعر" />
            <x-button type="submit" width="1/4" label="حفظ" />

        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$halls" :cells="$cells" />
    </x-container>
</div>
