<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExpense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getBankNameAttribute()
    {
        return $this->bank->bank_name ?? "";
    }

    public function getPaymentAttribute()
    {
        return $this->payment_method == "cash" ? 'كاش' : 'بنك';
    }

    public function getNameAttribute()
    {
        return $this->employee->name;
    }

    public function getEmployeeExpenseTypeAttribute()
    {
        if ($this->type == "salary") {
            $type = "مرتب";
        } elseif ($this->type == "bonus") {
            $type = "حافز";
        } elseif ($this->type == "debt") {
            $type = "دين";
        } elseif ($this->type == "paid") {
            $type = "سداد دين";
        } elseif ($this->type == "discount") {
            $type = "خصم من الديون";
        }
        return $type;
    }
}
