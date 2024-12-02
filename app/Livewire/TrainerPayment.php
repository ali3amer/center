<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TrainerPayment extends Component
{
    public $batch_id;
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];

    public $headers = ['المبغ', 'التاريخ', 'وسيلة الدفع'];
    public $cells = ['amount' => 'amount', 'date' => 'date', 'payment_method' => 'payment_method'];

    public $batch_student_id;
    public $id = null;
    public $amount = 0;
    public $date = '';
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $bank_id = null;
    public $banks = [];
    public $transaction_id = '';
    public $hall_id = null;

    public function mount()
    {
        $this->cells['payment_method'] = $this->payment_methods;
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();
    }

    public function save()
    {
        if ($this->id == null) {
            \App\Models\BatchTrainerPayment::create([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'batch_id' => $this->batch_id,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
            ]);
        } else {
            \App\Models\BatchTrainerPayment::where('id', $this->id)->update([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($batchTrainerPayment)
    {
        $this->id = $batchTrainerPayment['id'];
        $this->amount = $batchTrainerPayment['amount'];
        $this->date = $batchTrainerPayment['date'];
        $this->payment_method = $batchTrainerPayment['payment_method'];
        $this->bank_id = $batchTrainerPayment['bank_id'];
        $this->transaction_id = $batchTrainerPayment['transaction_id'];
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
        \App\Models\BatchTrainerPayment::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('amount', 'date', 'payment_method', 'bank_id', 'transaction_id', 'id');
        $this->dispatch('update-trainer', $this->batch_id);
    }

    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.trainer-payment', [
            'batchTrainerPayments' => \App\Models\BatchTrainerPayment::where('batch_id', $this->batch_id)->paginate(10),
        ]);
    }
}
