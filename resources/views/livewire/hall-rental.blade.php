<div>
    <x-container title="حجوزات القاعه">
        <form wire:submit="save">
            <div class="grid gap-x-1 grid-cols-5">
                <x-input name="name" :disabled="$rentalPaymentMode" label="الإسم"/>
                <x-select name="type" :disabled="$rentalPaymentMode" :options="$types" label="نوع المؤجر"/>
                <x-select name="duration_type" :disabled="$rentalPaymentMode" :options="$duration_types" label="نوع الفتره"/>
                <x-input name="price" :disabled="$rentalPaymentMode" :live="true" label="السعر"/>
                <x-input name="duration" :disabled="$rentalPaymentMode" :live="true" label="طول الفتره"/>
            </div>
            <div class="grid gap-x-1 grid-cols-5">
                <x-input type="date" name="start_date" :disabled="$rentalPaymentMode" label="بداية الفترة"/>
                <x-input type="date" name="end_date" :disabled="$rentalPaymentMode" label="نهاية الفترة"/>
                <x-input name="cost" :disabled="true" :live="true" label="التكلفه الكليه"/>
                <x-input name="remainder" :disabled="true" label="المتبقي"/>
                @if(!$rentalPaymentMode)
                    <x-button type="submit" model="hallRentals" label="حفظ"/>
                @else
                    <x-button type="button" model="hallRentals" color="bg-red-600" wire:click="resetData('rentalPaymentMode')" label=""
                              icon="fa-close"/>
                @endif
            </div>
        </form>
    </x-container>

    @if(!$rentalPaymentMode)
        <x-container>
            <x-table :headers="$headers" :rows="$hallRentals" :$functions :$numbers model="hallRentals" chooseModel="hallRentalPayments" :search="false" chooseText="مدفوعات الحجز" :choose="true" :cells="$cells" />
        </x-container>
    @else
        <livewire:hall-rental-payment :$hall_rental_id />
    @endif
</div>
