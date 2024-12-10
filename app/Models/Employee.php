<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employeeExpenses()
    {
        return $this->hasMany(EmployeeExpense::class);
    }

    public function getBalanceAttribute()
    {
        return $this->employeeExpenses->where('type', 'debt')->sum('amount') - $this->employeeExpenses->where('type', 'paid')->sum('amount') - $this->employeeExpenses->where('type', 'discount')->sum('amount');
    }
}
