<div>
    <x-container>
        <form wire:submit="save" class="flex flex-wrap">
            <x-input name="name" width="1/3" label="الإسم"/>
            <x-input name="username" width="1/3" label="الإسم المستخدم"/>
            <x-input name="password" type="password" width="1/3" label="كلمة السر"/>

            <x-button type="submit" label="حفظ"/>
        </form>
    </x-container>

    <x-container>
        <x-table :headers="$headers" :rows="$users" :cells="$cells"/>
    </x-container>
</div>
