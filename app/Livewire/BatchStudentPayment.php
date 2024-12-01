<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BatchStudentPayment extends Component
{
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
            \App\Models\BatchStudentPayment::create([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'batch_student_id' => $this->batch_student_id,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
            ]);
        } else {
            \App\Models\BatchStudentPayment::where('id', $this->id)->update([
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

    public function edit($batchStudentPayment)
    {
        $this->id = $batchStudentPayment['id'];
        $this->amount = $batchStudentPayment['amount'];
        $this->date = $batchStudentPayment['date'];
        $this->payment_method = $batchStudentPayment['payment_method'];
        $this->bank_id = $batchStudentPayment['bank_id'];
        $this->transaction_id = $batchStudentPayment['transaction_id'];
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
        \App\Models\BatchStudentPayment::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-price');

        $this->reset('amount', 'date', 'payment_method', 'bank_id', 'transaction_id', 'id');
    }
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.batch-student-payment', [
            'batchStudentPayments' => \App\Models\BatchStudentPayment::where('batch_student_id', $this->batch_student_id)->paginate(10),
        ]);
    }
}
