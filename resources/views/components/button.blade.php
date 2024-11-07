@props(['type' => 'button', 'label' => 'Button', 'color' => 'blue'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => "px-4 py-2 bg-$color-500 text-white rounded hover:bg-$color-600"]) }}>
    {{ $label }}
</button>
