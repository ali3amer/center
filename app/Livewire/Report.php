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

    public $types = [
        'daily' => 'يوميه',
        'expenses' => 'المصروفات',
        'courses' => 'البرامج التدريبيه',
    ];
    public function getReport()
    {

    }
    #[Title('التقارير')]
    public function render()
    {
        return view('livewire.report');
    }
}
