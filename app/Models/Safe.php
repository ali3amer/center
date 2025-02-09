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
        $prev_date = date('Y-m-d', strtotime($from . ' -1 day'));
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
                "created_at" => 'الدارس :' . $batchStudentPayment->created_at,
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
                "note" => 'المدرب : ' . $batchTrainerPayment->batch->name,
                "created_at" => $batchTrainerPayment->created_at,
                "updated_at" => $batchTrainerPayment->updated_at,
            ];
        }

        $batchCertificationPayments = BatchCertificationPayment::whereBetween('date', [$from, $to])->get();
        foreach ($batchCertificationPayments as $batchCertificationPayment) {
            $movements[] = [
                "income" => 0,
                "expense" => $batchCertificationPayment->amount,
                "date" => $batchCertificationPayment->date,
                "payment_method" => $batchCertificationPayment->payment,
                "transaction_id" => $batchCertificationPayment->transaction_id,
                "bank_id" => $batchCertificationPayment->bankName,
                "note" => 'شهادات برنامج : ' . $batchCertificationPayment->batch->courseName,
                "created_at" => $batchCertificationPayment->created_at,
                "updated_at" => $batchCertificationPayment->updated_at,
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
                "note" => 'قاعة : ' . $hallRentalPayment->hallRental->hall->name,
                "created_at" => $hallRentalPayment->created_at,
                "updated_at" => $hallRentalPayment->updated_at,
            ];
        }

        $employeeExpenses = EmployeeExpense::whereBetween('date', [$from, $to])->get();
        foreach ($employeeExpenses as $employeeExpense) {
            $movements[] = [
                "income" => $employeeExpense->type == "paid" ? $employeeExpense->amount : 0,
                "expense" => $employeeExpense->type != "paid" && $employeeExpense->type != "discount" ? $employeeExpense->amount : 0,
                "date" => $employeeExpense->date,
                "payment_method" => $employeeExpense->payment,
                "transaction_id" => $employeeExpense->transaction_id,
                "bank_id" => $employeeExpense->bankName,
                "note" => 'الموظف : ' . $employeeExpense->employee->name,
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
                "note" => 'مصروفات' . $expense->description . " | " . $expense->name,
                "created_at" => $expense->created_at,
                "updated_at" => $expense->updated_at,
            ];
        }

        $cashTransfers = Transfer::whereBetween('date', [$from, $to])->where('transfer_type', 'cash_to_bank')->get();
        foreach ($cashTransfers as $transfer) {
            $movements[] = [
                "income" => 0,
                "expense" => $transfer->amount,
                "date" => $transfer->date,
                "payment_method" => "كاش",
                "transaction_id" => $transfer->transaction_id,
                "bank_id" => $transfer->bankName,
                "note" => "تحويل من كاش الى بنك",
                "created_at" => $transfer->created_at,
                "updated_at" => $transfer->updated_at,
            ];

            $movements[] = [
                "income" => $transfer->amount,
                "expense" => 0,
                "date" => $transfer->date,
                "payment_method" => "بنك",
                "transaction_id" => $transfer->transaction_id,
                "bank_id" => $transfer->bankName,
                "note" => "تحويل من كاش الى بنك",
                "created_at" => $transfer->created_at,
                "updated_at" => $transfer->updated_at,
            ];
        }

        $bankTransfers = Transfer::whereBetween('date', [$from, $to])->where('transfer_type', 'bank_to_cash')->get();
        foreach ($bankTransfers as $transfer) {
            $movements[] = [
                "income" => 0,
                "expense" => $transfer->amount,
                "date" => $transfer->date,
                "payment_method" => "بنك",
                "transaction_id" => $transfer->transaction_id,
                "bank_id" => $transfer->bankName,
                "note" => "تحويل من بنك الى كاش",
                "created_at" => $transfer->created_at,
                "updated_at" => $transfer->updated_at,
            ];

            $movements[] = [
                "income" => $transfer->amount,
                "expense" => 0,
                "date" => $transfer->date,
                "payment_method" => "كاش",
                "transaction_id" => $transfer->transaction_id,
                "bank_id" => $transfer->bankName,
                "note" => "تحويل من بنك الى كاش",
                "created_at" => $transfer->created_at,
                "updated_at" => $transfer->updated_at,
            ];
        }


        $initial_balance = Safe::sum("initial_balance")
            + BatchStudentPayment::where('date', '<', $from)->sum('amount')
            - BatchTrainerPayment::where('date', '<', $from)->sum('amount')
            - BatchCertificationPayment::where('date', '<', $from)->sum('amount')
            + HallRentalPayment::where('date', '<', $from)->sum('amount')
            + EmployeeExpense::where('type', 'paid')->where('date', '<', $from)->sum('amount')
            - EmployeeExpense::where('type', '!=', 'discount')->where('type', '!=', 'paid')->where('date', '<', $from)->sum('amount')
            - Expense::where('date', '<', $from)
                ->get()
                ->sum(function ($expense) {
                    return $expense->price * $expense->quantity;
                });
        $movements[] = [
            "income" => $initial_balance,
            "expense" => 0,
            "date" => $prev_date,
            "payment_method" => "",
            "transaction_id" => null,
            "bank_id" => null,
            "note" => "رصيد الفتره السابقه",
            "created_at" => $prev_date,
            "updated_at" => $prev_date,
        ];

        $expense_balance = $expenses->sum('amount') + $batchTrainerPayments->sum('amount') + $employeeExpenses->where('type', '!=', 'paid')->where('type', '!=', 'discount')->sum('amount') + $batchCertificationPayments->sum('amount');
        $income_balance = $hallRentalPayments->sum('amount') + $batchStudentPayments->sum('amount') + $initial_balance;
        $movements = collect($movements)->sortBy('date')->toArray();
        return ['movements' => $movements, 'expenses_balance' => $expense_balance, 'income_balance' => $income_balance, 'initial_balance' => $initial_balance];

    }
}
