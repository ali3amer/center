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
                "payment_method" => $batchStudentPayment->payment,
                "transaction_id" => $batchStudentPayment->transaction_id,
                "bank_id" => $batchStudentPayment->bankName,
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
                "payment_method" => $batchTrainerPayment->payment,
                "transaction_id" => $batchTrainerPayment->transaction_id,
                "bank_id" => $batchTrainerPayment->bankName,
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
                "payment_method" => $hallRentalPayment->payment,
                "transaction_id" => $hallRentalPayment->transaction_id,
                "bank_id" => $hallRentalPayment->bankName,
                "note" => $hallRentalPayment->hallRental->hall->name,
                "created_at" => $hallRentalPayment->created_at,
                "updated_at" => $hallRentalPayment->updated_at,
            ];
        }

        $employeeExpenses = EmployeeExpense::whereBetween('date', [$from, $to])->get();
        foreach ($employeeExpenses as $employeeExpense) {
            $movements[] = [
                "income" => $employeeExpense->type == "paid" ? $employeeExpense->amount : 0,
                "expense" => $employeeExpense->type != "paid" ? $employeeExpense->amount : 0,
                "date" => $employeeExpense->date,
                "payment_method" => $employeeExpense->payment,
                "transaction_id" => $employeeExpense->transaction_id,
                "bank_id" => $employeeExpense->bankName,
                "note" => $employeeExpense->employee->name,
                "created_at" => $employeeExpense->created_at,
                "updated_at" => $employeeExpense->updated_at,
            ];
        }

        $expenses = Expense::whereBetween('date', [$from, $to])->get();
        foreach ($expenses as $expense) {
            $movements[] = [
                "income" => 0,
                "expense" => $expense->amount,
                "date" => $expense->date,
                "payment_method" => $expense->payment,
                "transaction_id" => $expense->transaction_id,
                "bank_id" => $expense->bankName,
                "note" => $expense->description . " | " . $expense->name,
                "created_at" => $expense->created_at,
                "updated_at" => $expense->updated_at,
            ];
        }

        $expense_balance = $expenses->sum('amount') + $batchTrainerPayments->sum('amount') + $employeeExpenses->where('type', '!=', 'paid')->where('type', '!=', 'discount')->sum('amount');
        $income_balance = $hallRentalPayments->sum('amount') + $batchStudentPayments->sum('amount');
        return ['movements' => $movements, 'expenses_balance' => $expense_balance, 'income_balance' => $income_balance];

    }
}
