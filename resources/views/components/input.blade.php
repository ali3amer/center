@props(['type' => 'text', 'name', 'label', 'width' => 'w-full']) <!-- العرض الافتراضي `w-full` -->

<div class="mb-4 {{ $width }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" {{ $attributes }} />
</div>
