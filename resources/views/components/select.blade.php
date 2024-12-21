@props(['name', 'label', 'options' => [], 'width' => 'full', 'placeholder' => 'اختر من القائمة', 'disabled' => false, 'live' => false]) <!-- العرض الافتراضي `w-full` -->

<div class=" w-{{ $width }}">
    <!-- Label -->
    <label for="{{ $name }}" class="block uppercase tracking-wide mt-2 text-gray-700 text-xs font-bold mb-2">
        {{ $label }}
    </label>

    <!-- Select Field -->
    <select name="{{ $name }}" id="{{ $name }}" @if($live) wire:model.live="{{ $name }}" @else wire:model="{{ $name }}" @endif
            @disabled($disabled) @disabled(empty($options)) class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" {{ $attributes }}>
        <!-- Placeholder -->
        <option value="">{{ $placeholder }}</option>

        <!-- Options -->
        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>

    <!-- Error Message -->
    <span class="text-red-500">@error($name) {{ $message }} @enderror</span>
</div>
