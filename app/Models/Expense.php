<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOption\Option;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenseOption()
    {
        return $this->belongsTo(ExpenseOption::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function getBankNameAttribute()
    {
        return $this->bank->bank_name ?? "";
    }

    public function getNameAttribute()
    {
        return $this->expenseOption->optionName ?? "غير مصنف";
    }

    public function getPaymentAttribute()
    {
        return $this->payment_method == "cash" ? 'كاش' : 'بنك';
    }

    public function getAmountAttribute()
    {
        return $this->quantity * $this->price;
    }

}
