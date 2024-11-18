<div>
    <x-container>
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="arabic_name" :disabled="$batchMode" label="الإسم بالعربي"/>
            <x-input name="english_name" :disabled="$batchMode" label="الإسم بالانجليزي"/>
            <x-select name="gender" :disabled="$batchMode" :options="$genders" label="الجنس"/>
            <x-input name="phone" :disabled="$batchMode" label="الهاتف"/>
            <x-input name="email" :disabled="$batchMode" label="البريد الالكتروني"/>
            <x-button type="submit" label="حفظ"/>
        </form>
    </x-container>


</div>
