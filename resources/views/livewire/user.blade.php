<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-4">
            <x-input name="name" label="الإسم"/>
            <x-input name="username" label="الإسم المستخدم"/>
            <x-input name="password" type="password" label="كلمة السر"/>

            <x-button type="submit" :center="true" label="حفظ"/>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$users" :cells="$cells"/>
    </x-container>
</div>
