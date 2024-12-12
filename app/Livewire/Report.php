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
    public $payment_methods = ['cash' => 'كاش', 'bank' => 'بنك'];
    public $payment_method = 'cash';
    public $from = '';
    public $to = '';
    public $types = [
        'safe' => 'تقرير الخزنه',
        'incomes' => 'تقرير الإيرادات',
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
        } elseif ($this->type === 'performance') {
            $this->performance();
        } elseif ($this->type === 'expenses') {
            $this->expenses();
        } elseif ($this->type === 'courses') {
            $this->courses();
        } elseif ($this->type === 'certifications') {
            $this->certifications();
        }
    }

    public function safe()
    {
        $this->cells = ["date", "note", "payment_method", "bank_id", "transaction_id", "income", "expense"];
        $this->headers = ['التاريخ', 'البيان', 'طريقة الدفعه', 'البنك', 'رقم العملية', 'إيراد', 'منصرف'];
        $safe = Safe::first()->safeMovements($this->from, $this->to);
        $this->rows =  collect($safe['movements']);
        $this->incomes = $safe['income_balance'];
        $this->expenses = $safe['expenses_balance'];
        $this->balance = $this->incomes - $this->expenses;
        $this->footers = ['الجمله', '', '', '', '', $this->incomes, $this->expenses];
        $this->putInSession();
    }

    public function incomes()
    {

    }

    public function performance()
    {
        $this->cells = ['courseName', 'courseType', 'studentCount', 'certificationsCount', 'name', 'month'];
        $this->headers = ['إسم البرنامج', 'نوع البرنامج', 'عدد الدارسين', 'عدد الشهادات', 'المدرب', 'الشهر'];

        $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get();
        $this->putInSession();

    }

    public function expenses()
    {
        $this->cells['options'] = ['optionName', 'amount'];
        $this->headers['options'] = ['التصنيف', 'المبلغ'];
        $this->rows['options'] = \App\Models\ExpenseOption::all()->map(function ($option) {
            $option->amount = $option->expenses->whereBetween("date", [$this->from, $this->to])->sum("amount");
            return $option;
        });

        $this->cells['expenses'] = ['date', 'description', 'name', 'amount'];
        $this->headers['expenses'] = ['التاريخ', 'البيان', 'التصنيف', 'المبلغ'];
        $this->rows['expenses'] = \App\Models\Expense::whereBetween("date", [$this->from, $this->to])->get();

        $this->putInSession();
    }

    public function courses()
    {
        $this->cells = ['courseName', 'studentCount'];
        $this->headers = ['إسم البرنامج', 'عدد الدارسين'];

        $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get();
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
        $this->putInSession();
    }

    public function putInSession()
    {
        session()->put('pdf_data', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'cells' => $this->cells,
            'footers' => $this->footers,
            'type' => $this->type,
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
        $html = view('pdf', ['rows' => $data['rows'], 'cells' => $data['cells'], 'headers' => $data['headers'], 'footers' => $data['footers'], 'type' => $data['type']])->render();
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
