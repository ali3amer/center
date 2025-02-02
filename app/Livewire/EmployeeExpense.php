<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class EmployeeExpense extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];

    public $cells = ['date', 'name', 'employeeExpenseType', 'payment', 'transaction_id', 'amount'];
    public $headers = ['التاريخ', 'إسم الموظف', 'نوع العملية', 'وسيلة الدفع', 'رقم العملية', 'المبلغ'];
    public $numbers = ['amount'];
    public $employee_id;
    public $id = null;
    public $amount = 0;
    public $type = 'salary';
    public $types = ['salary' => 'مرتب', 'bonus' => 'حافز', 'debt' => 'سلفيه', 'paid' => 'سداد', 'discount' => 'خصم من الديون'];
    public $date = '';
    public $payment_method = 'cash';
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $bank_id = null;
    public $banks = [];
    public $transaction_id = '';
    public $balance = 0;

    public function mount()
    {
        $this->banks = \App\Models\Bank::pluck('name', 'id')->toArray();
    }

    public function save()
    {
        if ($this->id == 0) {
            \App\Models\EmployeeExpense::create([
                'amount' => round(floatval($this->amount)),
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'employee_id' => $this->employee_id,
                'transaction_id' => $this->transaction_id,
                'type' => $this->type,
            ]);
        } else {
            \App\Models\EmployeeExpense::where('id', $this->id)->update([
                'amount' => round(floatval($this->amount)),
                'date' => $this->date,
                'payment_method' => $this->payment_method,
                'bank_id' => $this->bank_id,
                'employee_id' => $this->employee_id,
                'transaction_id' => $this->transaction_id,
                'type' => $this->type,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($employeeExpense)
    {
        $this->id = $employeeExpense['id'];
        $this->amount = round($employeeExpense['amount']);
        $this->date = $employeeExpense['date'];
        $this->payment_method = $employeeExpense['payment_method'];
        $this->bank_id = $employeeExpense['bank_id'];
        $this->transaction_id = $employeeExpense['transaction_id'];
        $this->type = $employeeExpense['type'];
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
        \App\Models\EmployeeExpense::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();

        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-balance');

        $this->reset('amount', 'type', 'date', 'payment_method', 'bank_id', 'banks', 'transaction_id');
    }

    public function choose($employee)
    {
        $this->employee_id = $employee['id'];
        $this->edit($employee);
        $this->employeeExpenseMode = true;
    }

    public function render()
    {
        $this->balance = \App\Models\Employee::find($this->employee_id)->balance;
        if ($this->payment_method == 'cash') {
            $this->bank_id = null;
        }
        if ($this->payment_method == "bank" && !empty($this->banks) && $this->bank_id == null) {
            $this->bank_id = array_key_first($this->banks);
        }
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.employee-expense', [
            'employeeExpenses' => \App\Models\EmployeeExpense::where('employee_id', $this->employee_id)->paginate(10),
        ]);
    }
}
