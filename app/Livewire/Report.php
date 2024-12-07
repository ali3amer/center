<?php

namespace App\Livewire;

use App\Models\Safe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $this->cells = ["date", "note", "payment_method" => $this->payment_methods, "bank_id", "transaction_id", "income", "expense"];
        $this->headers = ['التاريخ', 'البيان', 'طريقة الدفعه', 'البنك', 'رقم العملية', 'إيراد', 'منصرف'];
        $this->rows = Safe::first()->safeMovements($this->from, $this->to);
    }

    public function incomes()
    {

    }

    public function performance()
    {
        $this->cells = ['courseName', 'courseType', 'studentCount', 'certificationsCount', 'name', 'month'];
        $this->headers = ['إسم البرنامج', 'نوع البرنامج', 'عدد الدارسين', 'عدد الشهادات', 'المدرب', 'الشهر'];
//        $this->rows = \App\Models\Course::all()->map(function ($course) {
//            $course->course_type = $this->coruse_types[$course->type];
//            $course->trainer = $course->batches->whereBetween("start_date", [$this->from, $this->to])->first()->name ?? "";
//            $course->certifications = $course->batches->whereBetween("start_date", [$this->from, $this->to])->sum(function ($batch) {
//                return $batch->batchStudents->where('want_certification', true)->count();
//            });
//            $course->student_count = $course->batches->whereBetween("start_date", [$this->from, $this->to])->sum('studentCount');
//            return $course;
//        });

        $this->rows = \App\Models\Batch::whereBetween("start_date", [$this->from, $this->to])->get();
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
            $query->whereBetween("start_date", [$this->from, $this->to]);
        })->get();
        session()->put('pdf_data', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'cells' => $this->cells,
        ]);
        $this->redirectToPdf();
    }

    public function showPDF()
    {
        $data = session('pdf_data');
        // تحميل الـ PDF
        $pdf = Pdf::loadView('pdf', ['rows' => $data['rows'], 'cells' => $data['cells'], 'headers' => $data['headers']])->setPaper('a4', 'landscape');

        // تنزيل الملف مباشرة
//        return response()->streamDownload(function () use ($pdf) {
//            echo $pdf->output();
//        }, 'invoice.pdf');

        return response($pdf->stream('invoice.pdf'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function redirectToPdf()
    {
        $url = route('view.pdf'); // رابط الـ Route الذي يعرض PDF
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
