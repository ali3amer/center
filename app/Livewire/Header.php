<?php

namespace App\Livewire;

use App\Models\BatchTrainerPayment;
use App\Models\Safe;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $header;
    public $safe = 0;
    public $bank = 0;

    #[On('update-balance')]
    public function mount()
    {
        $this->safe = Safe::sum('initial_balance') + \App\Models\HallRentalPayment::where('payment_method', 'cash')->sum('amount')
            + \App\Models\BatchStudentPayment::where('payment_method', 'cash')->sum('amount')
            - BatchTrainerPayment::where('payment_method', 'cash')->sum('amount')
            + \App\Models\EmployeeExpense::where('payment_method', 'cash')->where('type', 'paid')->sum('amount')
            - \App\Models\EmployeeExpense::where('payment_method', 'cash')->where('type', '!=', 'paid')->where('type', '!=', 'discount')->sum('amount')
            - \App\Models\Expense::where('payment_method', 'cash')->sum('amount')
            - \App\Models\BatchCertificationPayment::where('payment_method', 'cash')->sum('amount')
            + \App\Models\Transfer::where('transfer_type', 'bank_to_cash')->sum('amount')
            - \App\Models\Transfer::where('transfer_type', 'cash_to_bank')->sum('amount');

        $this->bank = \App\Models\Bank::sum('initial_balance') + \App\Models\HallRentalPayment::where('payment_method', 'bank')->sum('amount')
            + \App\Models\BatchStudentPayment::where('payment_method', 'bank')->sum('amount')
            - BatchTrainerPayment::where('payment_method', 'bank')->sum('amount')
            + \App\Models\EmployeeExpense::where('payment_method', 'bank')->where('type', 'paid')->sum('amount')
            - \App\Models\EmployeeExpense::where('payment_method', 'bank')->where('type', '!=', 'paid')->where('type', '!=', 'discount')->sum('amount')
            - \App\Models\Expense::where('payment_method', 'bank')->sum('amount')
            - \App\Models\BatchCertificationPayment::where('payment_method', 'bank')->sum('amount')
            + \App\Models\Transfer::where('transfer_type', 'cash_to_bank')->sum('amount')
            - \App\Models\Transfer::where('transfer_type', 'bank_to_cash')->sum('amount');
        session([
            'cash_balance' => $this->safe,
            'bank_balance' => $this->bank,
        ]);
    }

    public function render()
    {
        return view('livewire.header');
    }
}
