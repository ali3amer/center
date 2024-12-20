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

    public $headers = ['التاريخ', 'المبغ', 'وسيلة الدفع', 'ملاحظات'];
    public $cells = ['date' => 'date', 'amount' => 'amount', 'payment_method' => 'payment_method', 'note' => 'note'];
    public $numbers = ['amount'];
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
    public $price = 0;
    public $remainder = 0;

    public function mount()
    {
        $this->cells['payment_method'] = $this->payment_methods;
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();

        $this->price = round(\App\Models\BatchStudent::find($this->batch_student_id)->batch->price);
        $this->remainder = round(floatval($this->price) - floatval(\App\Models\BatchStudentPayment::where("batch_student_id", $this->batch_student_id)->sum('amount')));

    }

    public function save()
    {
        if ($this->id == null) {
            \App\Models\BatchStudentPayment::create([
                'amount' => round(floatval($this->amount)),
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'batch_student_id' => $this->batch_student_id,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
                'note' => $this->note,
            ]);
        } else {
            \App\Models\BatchStudentPayment::where('id', $this->id)->update([
                'amount' => round(floatval($this->amount)),
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

    public function edit($batchStudentPayment)
    {
        $this->id = $batchStudentPayment['id'];
        $this->amount = round($batchStudentPayment['amount']);
        $this->date = $batchStudentPayment['date'];
        $this->payment_method = $batchStudentPayment['payment_method'];
        $this->bank_id = $batchStudentPayment['bank_id'];
        $this->transaction_id = $batchStudentPayment['transaction_id'];
        $this->note = $batchStudentPayment['note'];
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

        $this->dispatch('update-balance');

        $this->reset('amount', 'date', 'payment_method', 'bank_id', 'transaction_id', 'id');
    }
    public function render()
    {
        if ($this->payment_method == 'cash') {
            $this->bank_id = null;
        }
        if ($this->payment_method == "bank" && !empty($this->banks) && $this->bank_id == null) {
            $this->bank_id = array_key_first($this->banks);
        }
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        $this->remainder = round(floatval($this->price) - floatval(\App\Models\BatchStudentPayment::where("batch_student_id", $this->batch_student_id)->sum('amount')));

        return view('livewire.batch-student-payment', [
            'batchStudentPayments' => \App\Models\BatchStudentPayment::where('batch_student_id', $this->batch_student_id)->paginate(10),
        ]);
    }
}
