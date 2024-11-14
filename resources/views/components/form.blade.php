@props(['action'])

<form wire:submit.prevent="{{ $action }}">
    {{ $slot }}
    <x-button type="submit" py="3" color="bg-cyan-700" label="حفظ"/>
</form>
