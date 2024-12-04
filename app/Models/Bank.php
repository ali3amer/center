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
}
