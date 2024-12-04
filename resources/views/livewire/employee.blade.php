<div>
    <x-container title="الموظفين">
        <form wire:submit="save" class="grid gap-x-1 grid-cols-3">
            <x-input name="name" :disabled="$employeeExpenseMode" label="الإسم" />
            <x-input name="phone" :disabled="$employeeExpenseMode" label="الهاتف" />
            <x-input name="email" :disabled="$employeeExpenseMode" label="البريد الالكتروني" />
            <x-input name="position" :disabled="$employeeExpenseMode" label="الوظيفة" />
            <x-input name="salary" :disabled="$employeeExpenseMode" label="المرتب" />
            @if(!$employeeExpenseMode)
                <x-button type="submit" :center="true" label="حفظ"/>
            @else
                <x-button type="button" color="bg-red-600" wire:click="resetData" label=""
                          icon="fa-close"/>
            @endif
        </form>
    </x-container>

    @if(!$employeeExpenseMode)
    <x-container>
        <x-table :headers="$headers" :rows="$employees" :choose="true" :cells="$cells" />
    </x-container>
    @else
        <livewire:employee-expense :$employee_id />
    @endif
</div>
