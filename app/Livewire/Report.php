<?php

namespace App\Livewire;

use App\Models\Safe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class Report extends Component
{

    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = [];
    public $cells = [];
    public $numbers = [];
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $payment_method = 'cash';
    public $from = '';
    public $to = '';
    public $types = [
        'safe' => 'تقرير الخزنه',
//        'incomes' => 'تقرير الإيرادات',
        'halls' => 'تقرير القاعات',
        'performance' => 'تقرير الأداء',
        'expenses' => 'تقرير المنصرفات',
        'courses' => 'تقرير منفذ التدريب',
        'employees' => 'تقرير الموظفين',
        'certifications' => 'تقرير الشهادات',
        'students' => 'تقرير الدارسين',
    ];
    public $coruse_types = ['course' => 'كورس', 'session' => 'دورة', 'workshop' => 'ورشه'];
    public $report_types = ["trainer" => "المدرب", "course" => "البرنامج التدريبي"];
    public $report_type = "trainer";
    public $coruse_type = 'course';
    public $type = null;
    public $course_id = null;
    public $option_id = null;
    public $courses = [];
    public $trainers = [];
    public $options = [];
    public $rows;
    public $incomes = 0;
    public $expenses = 0;
    public $balance = 0;
    public array $footers = [];
    public $trainer_id = null;

    public function mount()
    {
        $this->courses = \App\Models\Course::pluck("arabic_name", "id")->toArray();
        $this->trainers = \App\Models\Trainer::pluck("arabic_name", "id")->toArray();
        $this->options = \App\Models\ExpenseOption::pluck("optionName", "id")->toArray();
    }

    public function getReport()
    {
        if ($this->type === 'safe') {
            $this->safe();
        } elseif ($this->type === 'incomes') {
            $this->incomes();
        } elseif ($this->type == 'halls') {
            $this->halls();
        } elseif ($this->type === 'performance') {
            $this->performance();
        } elseif ($this->type === 'expenses') {
            $this->expenses();
        } elseif ($this->type === 'courses') {
            $this->courses();
        } elseif ($this->type == "employees") {
            $this->employees();
        } elseif ($this->type === 'certifications') {
            $this->certifications();
        } elseif ($this->type === 'students') {
            $this->students();
        }
//        $this->putInSession();

    }

    public function safe()
    {
        $this->cells = ["date", "note", "payment_method", "bank_id", "transaction_id", "income", "expense"];
        $this->headers = ['التاريخ', 'البيان', 'طريقة الدفع', 'البنك', 'رقم العملية', 'إيراد', 'منصرف'];
        $safe = Safe::first()->safeMovements($this->from, $this->to);
        $this->rows = collect($safe['movements']);
        $this->incomes = $safe['income_balance'];
        $this->expenses = $safe['expenses_balance'];
        $this->balance = number_format($this->incomes - $this->expenses);
        $this->footers = ['الجمله', '', '', '', '', number_format(round($this->incomes)), number_format(round($this->expenses))];
        $this->numbers = ['income', 'expense'];
    }

    public function halls()
    {
        $this->headers = ['الجهه', 'نوع المؤجر', 'من', 'الى', 'المده', 'السعر', 'التكلفه'];
        $this->cells = ['name', 'rentType', 'start_date', 'end_date', "duration", "price", 'cost'];
        $this->rows = \App\Models\HallRental::whereBetween('start_date', [$this->from, $this->to])->get()->sortBy('start_date');
        $this->numbers = ['price', 'cost'];
        $sum = $this->rows->sum(function ($row) {
            return $row->price * $row->duration;
        });
        $this->footers = ['الجمله', '', '', '', '', '', number_format($sum)];
    }

    public function incomes()
    {

    }

    public function performance()
    {
        $this->cells = ['courseName', 'courseType', 'studentCount', 'certificationsCount', 'name', 'month'];
        $this->headers = ['إسم البرنامج', 'نوع البرنامج', 'عدد الدارسين', 'عدد الشهادات', 'المدرب', 'الشهر'];

        if ($this->course_id == null && $this->trainer_id == null) {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get()->sortBy('start_date');
        } else {
            if ($this->report_type == "course") {
                $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('course_id', $this->course_id)->get()->sortBy('start_date');
            } elseif ($this->report_type == "trainer") {
                $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id)->get()->sortBy('start_date');
            }
        }
        $totalCount = 0;
        $totalCertification = 0;
        foreach ($this->rows as $row) {
            $totalCount += $row->studentCount;
            $totalCertification += $row->certificationsCount;
        }

        $this->footers = ['الجمله', '', number_format(round($totalCount)), number_format(round($totalCertification)), '', ''];

    }

    public function expenses()
    {
        $this->cells['options'] = ['optionName', 'amount'];
        $this->headers['options'] = ['التصنيف', 'المبلغ'];

        $this->rows = [];

        $this->rows['options'][] = [
            'optionName' => "غير مصنف",
            'amount' => \App\Models\Expense::whereNull("expense_option_id")->whereBetween("date", [$this->from, $this->to])->get()->sum(function ($expense) {
                return $expense->price * $expense->quantity;
            }),
        ];

        $expenseOptions = \App\Models\ExpenseOption::get()->sortBy('date');
        foreach ($expenseOptions as $option) {
            $amount = $option->expenses->whereBetween("date", [$this->from, $this->to])->sum(function ($expense) {
                return $expense->price * $expense->quantity;
            });

            if ($amount > 0) {
                $this->rows['options'][] = [
                    'optionName' => $option->optionName,
                    'amount' => $amount,
                ];
            }
        }

        $this->numbers['expenses'] = ['amount'];
        $totalOptions = 0;
        foreach ($this->rows['options'] as $row) {
            $totalOptions += $row['amount'];
        }

        $this->footers['options'] = ['الجمله', number_format(round($totalOptions))];
        $this->numbers['options'] = ['amount'];

        $this->cells['expenses'] = ['description', 'name', 'price', 'quantity', 'amount', 'date'];
        $this->headers['expenses'] = ['البيان', 'التصنيف', 'سعر الوحده', 'الكمية', 'المبلغ', 'التاريخ'];
        $expenses = $this->option_id == null ? \App\Models\Expense::whereBetween("date", [$this->from, $this->to]) : \App\Models\Expense::whereBetween("date", [$this->from, $this->to])->where('expense_option_id', $this->option_id);
        $this->rows['expenses'] = $expenses
            ->get()->sortBy('date')
            ->map(function ($expense) {
                $expense->amount = $expense->price * $expense->quantity;
                return $expense;

            });
        $totalExpenses = 0;
        foreach ($this->rows['expenses'] as $row) {
            $totalExpenses += round($row->amount);
        }

        $this->footers['expenses'] = ['الجمله', '', '', '', number_format(round($totalExpenses)), ''];
        $this->numbers['expenses'] = ['amount', 'price'];
    }

    public function courses()
    {
        $this->cells = ['courseName', 'studentCount', 'certificationsCount'];
        $this->headers = ['إسم البرنامج', 'عدد الدارسين', 'عدد الشهادات'];

        if ($this->course_id == null && $this->trainer_id == null) {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get()->sortBy('date');
        } else {
            if ($this->report_type == "course") {
                $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('course_id', $this->course_id)->get()->sortBy('date');
            } elseif ($this->report_type == "trainer") {
                $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id)->get()->sortBy('date');
            }
        }

        $totalCount = 0;
        $totalCountCertification = 0;
        foreach ($this->rows as $row) {
            $totalCount += $row->studentCount;
            $totalCountCertification += $row->certificationsCount;
        }

        $this->footers = ['الجمله', number_format(round($totalCount)), number_format(round($totalCountCertification))];

    }

    public function employees()
    {
        $this->cells = ['date', 'name', 'employeeExpenseType', 'payment', 'transaction_id', 'amount'];
        $this->headers = ['التاريخ', 'إسم الموظف', 'نوع العملية', 'وسيلة الدفع', 'رقم العملية', 'المبلغ'];

        $this->rows = \App\Models\EmployeeExpense::whereBetween('date', [$this->from, $this->to])->where("type", "!=", "discount")->where("type", "!=", "paid")->get()->sortBy('date');
        $this->footers = ['الجمله', '', '', '', '', number_format(round($this->rows->sum("amount")))];
        $this->numbers = ['amount'];
    }

    public function certifications()
    {
        $this->cells = ['student_number', 'certification_id', 'name', 'course', 'courseType', 'trainer', 'month', 'certificationPrice'];
        $this->headers = ['الرقم المتسلسل', 'الرقم المتسلسل للشهادة', 'إسم الدارس', 'البرنامج التدريبي', 'نوع البرنامج', 'إسم المدرب', 'الشهر', 'الرسوم'];
        $this->rows = \App\Models\BatchStudent::whereHas('batch', function ($query) {
            if ($this->course_id == null && $this->trainer_id == null) {
                $query->whereBetween("start_date", [$this->from, $this->to])->whereNotNull("certification_id");
            } else {
                if ($this->report_type == "course") {
                    $query->whereBetween("start_date", [$this->from, $this->to])->whereNotNull("certification_id")->where('course_id', $this->course_id);
                } elseif ($this->report_type == "trainer") {
                    $query->whereBetween("start_date", [$this->from, $this->to])->whereNotNull("certification_id")->where('trainer_id', $this->trainer_id);
                }
            }
        })->get()->sortBy('start_date');
        $this->footers = [];
        $this->numbers = ['certificationPrice'];
    }

    public function students()
    {
        $this->cells = ['student_number', 'certification_id', 'name', 'course', 'courseType', 'trainer', 'month'];
        $this->headers = ['الرقم المتسلسل', 'الرقم المتسلسل للشهادة', 'إسم الدارس', 'البرنامج التدريبي', 'نوع البرنامج', 'إسم المدرب', 'الشهر'];
        $this->rows = \App\Models\BatchStudent::whereHas('batch', function ($query) {
            if ($this->course_id == null && $this->trainer_id == null) {
                $query->whereBetween("start_date", [$this->from, $this->to]);
            } else {
                if ($this->report_type == "course") {
                    $query->whereBetween("start_date", [$this->from, $this->to])->where('course_id', $this->course_id);
                } elseif ($this->report_type == "trainer") {
                    $query->whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id);
                }
            }
        })->get()->sortBy('start_date');
        $this->footers = [];
    }

    public function putInSession()
    {
        session()->put('pdf_data', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'cells' => $this->cells,
            'numbers' => $this->numbers,
            'footers' => $this->footers,
            'type' => $this->type,
            'types' => $this->types
        ]);
        $this->redirectToPdf();

    }

    public function showPDF()
    {
        $data = session('pdf_data');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L'
        ]);
        $html = view('pdf', ['rows' => $data['rows'], 'cells' => $data['cells'], 'headers' => $data['headers'], 'numbers' => $data['numbers'], 'footers' => $data['footers'], 'type' => $data['type'], 'types' => $data['types']])->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('mypdf.pdf', 'I');

    }

    public function redirectToPdf()
    {
        $url = route('view.pdf');
        $this->dispatch('openPdf', $url);
    }

    public function resetData()
    {
        $this->reset('headers', 'cells', 'numbers', 'payment_method', 'course_id', 'rows', 'incomes', 'expenses', 'balance', 'trainer_id');
    }


    #[Title('التقارير')]
    public function render()
    {

        if ($this->from == '') {
            $this->from = date('Y-m-d');
        }
        if ($this->to == '') {
            $this->to = date('Y-m-d');
        }

        return view('livewire.report', [
            'rows' => $this->rows,
        ]);
    }
}
