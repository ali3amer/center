<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Expense extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['البيان', 'التصنيف', 'المبلغ', 'وسيلة الدفع', 'التاريخ'];
    public $cells = ['description' => 'description', 'name' => 'name', 'amount' => 'amount', 'payment_method' => 'payment_method', 'date' => 'date'];
    public $numbers = ['amount'];
    protected $listeners = [
        'delete',
    ];
    public $id = 0;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $description = '';
    public $amount = 0;
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $date = '';
    public $search = '';
    public $expense_option_id = null;
    public $options = [];
    public bool $optionMode = false;
    public $bank_id = null;
    public $banks = [];
    public $transaction_id = '';

    #[On('update-expenses')]
    public function mount()
    {
        $this->cells['payment_method'] = $this->payment_methods;
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();
        $this->options = \App\Models\ExpenseOption::pluck('optionName', 'id')->toArray();
    }
    public function save()
    {
        $this->validate();

        if ($this->id == 0) {
            \App\Models\Expense::create([
                'description' => $this->description,
                'expense_option_id' => $this->expense_option_id,
                'amount' => round(floatval($this->amount)),
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
            ]);
        } else {
            \App\Models\Expense::where('id', $this->id)->update([
                'description' => $this->description,
                'expense_option_id' => $this->expense_option_id,
                'amount' => round(floatval($this->amount)),
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'transaction_id' => $this->transaction_id,
                'date' => $this->date,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($expense)
    {
        $this->id = $expense['id'];
        $this->description = $expense['description'];
        $this->expense_option_id = $expense['expense_option_id'];
        $this->amount = round($expense['amount']);
        $this->date = $expense['date'];
        $this->payment_method = $expense['payment_method'];
        $this->bank_id = $expense['bank_id'];
        $this->transaction_id = $expense['transaction_id'];
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
        \App\Models\Expense::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-balance');

        $this->reset('description', 'amount', 'date', 'search', 'id', 'expense_option_id');
    }
    #[Title('المصروفات')]
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
        return view('livewire.expense', [
            'expenses' => \App\Models\Expense::where('description', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }
}
