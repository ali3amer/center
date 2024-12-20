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
        'certifications' => 'تقرير الشهادات',
    ];
    public $coruse_types = ['course' => 'كورس', 'session' => 'دورة', 'workshop' => 'ورشه'];
    public $coruse_type = 'course';
    public $type = null;
    public $trainer_id = null;
    public $trainers = [];
    public $rows;
    public $incomes = 0;
    public $expenses = 0;
    public $balance = 0;
    public array $footers = [];

    public function mount()
    {
        $this->trainers = \App\Models\Trainer::pluck("arabic_name", "id")->toArray();
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
        } elseif ($this->type === 'certifications') {
            $this->certifications();
        }
        $this->putInSession();

    }

    public function safe()
    {
        $this->cells = ["date", "note", "payment_method", "bank_id", "transaction_id", "income", "expense"];
        $this->headers = ['التاريخ', 'البيان', 'طريقة الدفعه', 'البنك', 'رقم العملية', 'إيراد', 'منصرف'];
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
        $this->rows = \App\Models\HallRental::whereBetween('start_date', [$this->from, $this->to])->get();
        $this->numbers = ['price', 'cost'];

    }

    public function incomes()
    {

    }

    public function performance()
    {
        $this->cells = ['courseName', 'courseType', 'studentCount', 'certificationsCount', 'name', 'month'];
        $this->headers = ['إسم البرنامج', 'نوع البرنامج', 'عدد الدارسين', 'عدد الشهادات', 'المدرب', 'الشهر'];

        if ($this->trainer_id == null) {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get();
        } else {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id)->get();
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

        $this->rows['options'][] = [
            'optionName' => "غير مصنف",
            'amount' => \App\Models\Expense::whereNull("expense_option_id")->whereBetween("date", [$this->from, $this->to])->sum("amount"),
        ];

        $expenseOptions = \App\Models\ExpenseOption::all();
        foreach ($expenseOptions as $option) {
            $this->rows['options'][] = [
                'optionName' => $option->optionName,
                'amount' => $option->expenses->whereBetween("date", [$this->from, $this->to])->sum("amount"),
            ];
        }

        $this->numbers['expenses'] = ['amount'];
        $totalOptions = 0;
        foreach ($this->rows['options'] as $row) {
            $totalOptions += $row['amount'];
        }

        $this->footers['options'] = ['الجمله', number_format(round($totalOptions))];
        $this->numbers['options'] = ['amount'];

        $this->cells['expenses'] = ['date', 'description', 'name', 'amount'];
        $this->headers['expenses'] = ['التاريخ', 'البيان', 'التصنيف', 'المبلغ'];
        $this->rows['expenses'] = \App\Models\Expense::whereBetween("date", [$this->from, $this->to])->get();
        $totalExpenses = 0;
        foreach ($this->rows['expenses'] as $row) {
            $totalExpenses += $row->amount;
        }

        $this->footers['expenses'] = ['الجمله', '', '', number_format(round($totalExpenses))];
        $this->numbers['expenses'] = ['amount'];
    }

    public function courses()
    {
        $this->cells = ['courseName', 'studentCount'];
        $this->headers = ['إسم البرنامج', 'عدد الدارسين'];

        if ($this->trainer_id == null) {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get();
        } else {
            $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id)->get();
        }

        $totalCount = 0;
        foreach ($this->rows as $row) {
            $totalCount += $row->studentCount;
        }

        $this->footers = ['الجمله', number_format(round($totalCount))];

    }

    public function certifications()
    {
        $this->cells = ['student_id', 'certificationId', 'name', 'course', 'courseType', 'trainer', 'month', 'certificationPrice'];
        $this->headers = ['الرقم المتسلسل', 'الرقم المتسلسل للشهادة', 'إسم الدارس', 'البرنامج التدريبي', 'نوع البرنامج', 'إسم المدرب', 'الشهر', 'الرسوم'];
        $this->rows = \App\Models\BatchStudent::whereHas('batch', function ($query) {
            if ($this->trainer_id == null) {
                $query->whereBetween("start_date", [$this->from, $this->to]);
            } else {
                $query->whereBetween("start_date", [$this->from, $this->to])->where('trainer_id', $this->trainer_id);
            }
        })->get();
        $this->footers = [];
        $this->numbers = ['certificationPrice'];
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
