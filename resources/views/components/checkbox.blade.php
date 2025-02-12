@props([
    'name',                // اسم الحقل
    'label' => '',         // نص التسمية (اختياري)
    'checked' => false,    // هل الحقل محدد افتراضيًا؟
    'disabled' => false,
    'live' => false
])


<div class="flex @if($errors->any()) items-center @else items-end @endif mb-4">
    <input id="{{$name}}" @disabled($disabled) type="checkbox" {{ $checked ? 'checked' : '' }} @if($live) wire:model.live="{{$name}}" @else wire:model="{{$name}}" @endif class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    <label for="{{$name}}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$label}}</label>
</div>
