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

    public $headers = ['التاريخ', 'المبغ', 'وسيلة الدفع', 'ملاحظات'];
    public $cells = ['date' => 'date', 'amount' => 'amount', 'payment_method' => 'payment_method', 'note' => 'note'];
    public $batch_student_id;
    public $id = null;
    public $amount = 0;
    public $date = '';
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $bank_id = null;
    public $banks = [];
    public $transaction_id = '';
    public $note = null;

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
                'note' => $this->note,
            ]);
        } else {
            \App\Models\BatchTrainerPayment::where('id', $this->id)->update([
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

    public function edit($batchTrainerPayment)
    {
        $this->id = $batchTrainerPayment['id'];
        $this->amount = $batchTrainerPayment['amount'];
        $this->date = $batchTrainerPayment['date'];
        $this->payment_method = $batchTrainerPayment['payment_method'];
        $this->bank_id = $batchTrainerPayment['bank_id'];
        $this->transaction_id = $batchTrainerPayment['transaction_id'];
        $this->note = $batchTrainerPayment['note'];
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
        $this->dispatch('update-balance');

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
