@props(['icon' => '', 'mt' => '2' , 'px' => '4', 'py' => '2','type' => 'button', 'label' => '', 'color' => 'bg-cyan-800', 'hoverColor' => 'bg-cyan-700', 'width' => 'w-full', 'icon'])


<div class="px-3 flex items-end">
    <button
        type="{{ $type }}" {{ $attributes->merge(['class' => "$width px-$px mt-$mt py-$py $color text-white rounded hover:$hoverColor"]) }}>
        {{ $label }}
        @if($icon != '')
            <i class="fa {{$icon}} fa-xs"></i>
        @endif
    </button>
</div>
