<div>
    <x-container>
        <livewire:dynamic-form
            submit-method="customSubmit"
            :$fields
            :submit-params="['parameter1', 42]"
        />
    </x-container>


    <x-container>
        <div class="overflow-x-auto">
            <livewire:dynamic-table :columns="$columns" :data="$data"/>
        </div>
    </x-container>
</div>
