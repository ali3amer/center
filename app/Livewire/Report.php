<?php

namespace App\Livewire;

use App\Models\Safe;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

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
        $this->cells = ['arabic_name', 'course_type', 'student_count', 'certifications', 'trainer', 'month'];
        $this->headers = ['إسم البرنامج', 'نوع البرنامج', 'عدد الدارسين', 'عدد الشهادات', 'المدرب', 'الشهر'];
        $this->rows = \App\Models\Course::all()->map(function ($course) {
            $course->course_type = $this->coruse_types[$course->type];
            $course->trainer = $course->batches->whereBetween("start_date", [$this->from, $this->to])->first()->name ?? "";
            $course->certifications = $course->batches->whereBetween("start_date", [$this->from, $this->to])->sum(function ($batch) {
                return $batch->batchStudents->where('want_certification', true)->count();
            });
            $course->student_count = $course->batches->whereBetween("start_date", [$this->from, $this->to])->sum('studentCount');
            return $course;
        });
    }

    public function expenses()
    {

    }

    public function courses()
    {
        $this->cells = ['arabic_name', 'student_count'];
        $this->headers = ['إسم البرنامج', 'عدد الدارسين'];
        $this->rows = \App\Models\Course::all()->map(function ($course) {
            $course->student_count = $course->batches->whereBetween("start_date", [$this->from, $this->to])->sum('studentCount');
            return $course;
        });
    }

    public function certifications()
    {
        $this->cells = ['student_id', 'certificationId', 'name', 'course', 'course_type', 'trainer', 'month', 'certificationPrice'];
        $this->headers = ['الرقم المتسلسل', 'الرقم المتسلسل للشهادة', 'إسم الدارس', 'البرنامج التدريبي', 'نوع البرنامج', 'إسم المدرب', 'الشهر', 'الرسوم'];
        $this->rows = \App\Models\BatchStudent::whereHas('batch', function ($query) {
            $query->whereBetween("start_date", [$this->from, $this->to]);
        })->get();
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
