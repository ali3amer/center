<?php

namespace App\Livewire;

use App\Models\BatchTrainerPayment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BatchCertificationPayment extends Component
{
    public $batch_id;
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];

    public $headers = ['التاريخ', 'المبغ', 'وسيلة الدفع', 'ملاحظات'];
    public $cells = ['date', 'amount', 'payment','note'];
    public $numbers = ['amount'];
    public $batch_student_id;
    public $id = null;
    public $amount = 0;
    public $date = '';
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $bank_id;
    public $banks = [];
    public $transaction_id = '';
    public $note = null;
    public $trainer_id = null;
    public $certificate_price = 0;
    public $studentCount = 0;
    public $cost = 0;
    public $center_fees = 60;
    public $trainer_fees = 40;
    public $paid = 0;
    public $certificate_cost = 0;
    public $required = 0;
    public $remainder = 0;
    public $price = 0;

    public function mount()
    {
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();
        $batch = \App\Models\Batch::find($this->batch_id);
        $this->batch_id = $batch['id'];
        $this->trainer_id = $batch['trainer_id'];
        $this->certificate_price = round($batch['certificate_price']);
        $this->price = round($batch['price']);
        $this->studentCount = $batch->studentCount;
        $this->cost = $this->price * $this->studentCount;
        $this->center_fees = $batch['center_fees'];
        $this->trainer_fees = $batch['trainer_fees'];
        $this->paid = round(\App\Models\BatchCertificationPayment::where('batch_id', $batch['id'])->sum('amount'));
        $this->certificate_cost = round($this->certificate_price * \App\Models\BatchStudent::where('batch_id', $batch['id'])->where('want_certification', true)->count());
        $this->required = round($this->certificate_cost);
        $this->remainder = round($this->required - $this->paid);
    }

    public function save()
    {
        if ($this->id == null) {
            \App\Models\batchCertificationPayment::create([
                'amount' => $this->amount,
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'batch_id' => $this->batch_id,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
                'note' => $this->note,
            ]);
        } else {
            \App\Models\batchCertificationPayment::where('id', $this->id)->update([
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
        $this->amount = round($batchTrainerPayment['amount']);
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
        \App\Models\BatchCertificationPayment::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-balance');
        $this->remainder = $this->required - \App\Models\BatchCertificationPayment::where('batch_id', $this->batch_id)->sum('amount');
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
        return view('livewire.batch-certification-payment', [
            'batchCertificationPayments' => \App\Models\BatchCertificationPayment::where('batch_id', $this->batch_id)->paginate(10),
        ]);
    }
}
