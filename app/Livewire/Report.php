<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Report extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['المدرب', 'تاريخ البداية', 'تاريخ النهاية', 'مكتمل', 'عدد الدارسين'];
    public $cells = ['name' => 'name', 'start_date' => 'start_date', 'end_date' => 'end_date', 'completed' => [true => 'نعم', false => 'لا'], 'studentCount'];

    public $from = '';
    public $to = '';
    public $types = [
        'daily' => 'تقرير يوميه',
        'incomes' => 'تقرير الإيرادات',
        'performance' => 'تقرير الأداء',
        'expenses' => 'تقرير المنصرفات',
        'courses' => 'تقرير منفذ التدريب',
        'certifications' => 'تقرير شهادات البرامج التدريبيه المنفذه',
    ];
    public $type = 'daily';

    public function getReport()
    {
        if ($this->type === 'daily') {
            $this->daily();
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

    public function daily()
    {

    }

    public function incomes()
    {

    }

    public function performance()
    {

    }

    public function expenses()
    {

    }

    public function courses()
    {

    }

    public function certifications()
    {

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
        return view('livewire.report');
    }
}
