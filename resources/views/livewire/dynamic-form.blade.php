<div>

    <form wire:submit.prevent="$parent.save" class="w-full">
            <div class="flex flex-wrap">
                @foreach ($fields as $field)
                    <x-input
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] }}"
                        width="{{ $field['width'] ?? 'full' }}"
                        wire:model.defer="formData.{{ $field['name'] }}"
                    />
                @endforeach
                    <div  class="mb-0 flex px-3 mt-2 items-center w-1/6">
                    <x-button type="submit" py="2" color="bg-cyan-700" label="حفظ"/>
                    </div>
            </div>
    </form>

</div>
