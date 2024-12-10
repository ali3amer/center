<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function batchStudentPayments()
    {
        return $this->hasMany(BatchStudentPayment::class);
    }

    public function batchTrainerPayments()
    {
        return $this->hasMany(BatchTrainerPayment::class);
    }

    public function hallRentalPayments()
    {
        return $this->hasMany(HallRentalPayment::class);
    }

    public function employeeExpenses()
    {
        return $this->hasMany(EmployeeExpense::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getBalanceAttribute()
    {
        return $this->initial_balance + $this->batchStudentPayments->sum('amount') + $this->hallRentalPayments->sum('amount') + $this->transfers->where('transfer_type', 'cash_to_bank')->sum('amount') - $this->transfers->where('transfer_type', 'bank_to_cash')->sum('amount') - $this->employeeExpenses->where('type', 'debt')->sum('amount') - $this->employeeExpenses->where('type', 'paid')->sum('amount') - $this->employeeExpenses->where('type', 'discount')->sum('amount') - $this->batchTrainerPayments->sum('amount') - $this->expenses->sum('amount');
    }
}
