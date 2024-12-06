<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function safeMovements($from, $to)
    {
        $movements = [];
        $batchStudentPayments = BatchStudentPayment::whereBetween('date', [$from, $to])->get();
        foreach ($batchStudentPayments as $batchStudentPayment) {
            $movements[] = [
                "income" => $batchStudentPayment->amount,
                "expense" => 0,
                "date" => $batchStudentPayment->date,
                "payment_method" => $batchStudentPayment->payment_method,
                "transaction_id" => $batchStudentPayment->transaction_id,
                "bank_id" => $batchStudentPayment->bank_id,
                "note" => $batchStudentPayment->batchStudent->name,
                "created_at" => $batchStudentPayment->created_at,
                "updated_at" => $batchStudentPayment->updated_at,
            ];
        }
        $batchTrainerPayments = BatchTrainerPayment::whereBetween('date', [$from, $to])->get();
        foreach ($batchTrainerPayments as $batchTrainerPayment) {
            $movements[] = [
                "income" => 0,
                "expense" => $batchTrainerPayment->amount,
                "date" => $batchTrainerPayment->date,
                "payment_method" => $batchTrainerPayment->payment_method,
                "transaction_id" => $batchTrainerPayment->transaction_id,
                "bank_id" => $batchTrainerPayment->bank_id,
                "note" => $batchTrainerPayment->batch->name,
                "created_at" => $batchTrainerPayment->created_at,
                "updated_at" => $batchTrainerPayment->updated_at,
            ];
        }

        $hallRentalPayments = HallRentalPayment::whereBetween('date', [$from, $to])->get();
        foreach ($hallRentalPayments as $hallRentalPayment) {
            $movements[] = [
                "income" => $hallRentalPayment->amount,
                "expense" => 0,
                "date" => $hallRentalPayment->date,
                "payment_method" => $hallRentalPayment->payment_method,
                "transaction_id" => $hallRentalPayment->transaction_id,
                "bank_id" => $hallRentalPayment->bank_id,
                "note" => $hallRentalPayment->hallRental->hall->name,
                "created_at" => $hallRentalPayment->created_at,
                "updated_at" => $hallRentalPayment->updated_at,
            ];
        }
        $employeeExpenses = EmployeeExpense::whereBetween('date', [$from, $to])->get();

        foreach ($employeeExpenses as $employeeExpense) {
            $movements[] = [
                "income" => 0,
                "expense" => $employeeExpense->amount,
                "date" => $employeeExpense->date,
                "payment_method" => $employeeExpense->payment_method,
                "transaction_id" => $employeeExpense->transaction_id,
                "bank_id" => $employeeExpense->bank_id,
                "note" => $employeeExpense->employee->name,
                "created_at" => $employeeExpense->created_at,
                "updated_at" => $employeeExpense->updated_at,
            ];
        }
        $expenses = Expense::whereBetween('date', [$from, $to])->get();
        foreach ($expenses as $expense) {
            $movements[] = [
                "income" => $expense->amount,
                "expense" => 0,
                "date" => $expense->date,
                "payment_method" => $expense->payment_method,
                "transaction_id" => $expense->transaction_id,
                "bank_id" => $expense->bank_id,
                "note" => $expense->description . " | " . $expense->name,
                "created_at" => $expense->created_at,
                "updated_at" => $expense->updated_at,
            ];
        }
        return $movements;

    }
}
