
@props(['type' => 'text', 'name', 'placeholder', 'label', 'width' => 'full', 'disabled' => false])

<div class="px-1 w-{{ $width }}">
    <label for="{{ $name }}" class="block uppercase tracking-wide mt-2 text-gray-700 text-xs font-bold mb-2">
        {{ $label }}
    </label>
    <input
        type="{{ $type }}"
        wire:model="{{ $name }}"
        placeholder="{{ $placeholder ?? $label }}"
        name="{{ $name }}"
        id="{{ $name }}" @disabled($disabled)
        class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
        {{ $attributes }}
    />
    <span class="text-red-500">@error($name) {{ $message }} @enderror</span>
</div>
