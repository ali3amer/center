@props(['type' => 'text', 'name', 'label', 'width' => 'full']) <!-- العرض الافتراضي `w-full` -->

<div  class="mb-0 px-3 md:mb-0 w-{{ $width }}">
    <label for="{{ $name }}" class=" block uppercase tracking-wide text-gray-700 text-xs font-bold mb-0">{{ $label }}</label>
    <input type="{{ $type }}" wire:model="{{ $name }}" name="{{ $name }}" id="{{ $name }}" class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-0 leading-tight focus:outline-none focus:bg-white" {{ $attributes }} />
    <span class="text-red-500">@error('name') {{ $message }} @enderror</span>
</div>
