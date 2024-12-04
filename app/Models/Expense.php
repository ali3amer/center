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

    public function getNameAttribute()
    {
        return $this->expenseOption->optionName ?? "غير مصنف";
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
