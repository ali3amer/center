<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class HallRentalPayment extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];

    public $headers = ['التاريخ', 'المبغ', 'وسيلة الدفع', 'ملاحظات'];
    public $cells = ['date' => 'date', 'amount' => 'amount', 'payment_method' => 'payment_method', 'note' => 'note'];
    public $hall_rental_id;
    public $id = null;
    public $amount = 0;
    public $date = '';
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $bank_id = null;
    public $banks = [];
    public $transaction_id = '';
    public $hall_id = null;
    public $note = null;
    public $cost = 0;
    public $remainder = 0;
    public $hall_rental;

    public function mount()
    {
        $this->cells['payment_method'] = $this->payment_methods;
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();
        $this->hall_rental = \App\Models\HallRental::find($this->hall_rental_id);
    }

    public function save()
    {
        if ($this->id == null) {
            \App\Models\HallRentalPayment::create([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'hall_rental_id' => $this->hall_rental_id,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
                'note' => $this->note,
            ]);
        } else {
            \App\Models\HallRentalPayment::where('id', $this->id)->update([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
                'note' => $this->note,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($hallRentalPayment)
    {
        $this->id = $hallRentalPayment['id'];
        $this->amount = $hallRentalPayment['amount'];
        $this->date = $hallRentalPayment['date'];
        $this->payment_method = $hallRentalPayment['payment_method'];
        $this->bank_id = $hallRentalPayment['bank_id'];
        $this->transaction_id = $hallRentalPayment['transaction_id'];
        $this->note = $hallRentalPayment['note'];
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "delete",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function delete($data)
    {
        \App\Models\HallRentalPayment::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-hall');

        $this->dispatch('update-balance');

        $this->reset('amount', 'date', 'payment_method', 'bank_id', 'transaction_id', 'id');
    }

    public function render()
    {
        $this->cost = $this->hall_rental->price * $this->hall_rental->duration;
        $this->remainder = $this->cost - \App\Models\HallRentalPayment::where('hall_rental_id', $this->hall_rental_id)->sum('amount');
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.hall-rental-payment', [
            'hallRentalPayments' => \App\Models\HallRentalPayment::where('hall_rental_id', $this->hall_rental_id)->paginate(10)
        ]);
    }
}
