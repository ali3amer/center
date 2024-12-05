@props(['center' => false,'icon' => '', 'mt' => '2' , 'px' => '4', 'py' => '3','type' => 'button', 'label' => '', 'color' => 'bg-cyan-800', 'hoverColor' => 'bg-cyan-700', 'width' => 'full', 'icon', 'disabled' => false])


<div class=" grow flex w-{{$width}} @if($errors->any() && $center) items-center @else items-end @endif">
    <button @disabled($disabled)
        type="{{ $type }}" {{ $attributes->merge(['class' => "w-full disabled:bg-cyan-200 px-$px mt-$mt py-$py $color text-white rounded hover:$hoverColor"]) }}>
        {{ $label }}
        @if($icon != '')
            <i class="fa {{$icon}} fa-xs"></i>
        @endif
    </button>
</div>
