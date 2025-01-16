<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Certification extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['رقم الطالب', 'رقم الشهادة', 'الإسم بالعربي', 'الإسم بالإنجليزي', 'البرنامج', 'نوع البرنامج', 'الشهر'];
    public $cells = ['student_number', 'certification_id', 'name', 'english_name', 'course', 'courseType', 'month'];
    protected $listeners = [
        'delete',
    ];

    public $search = '';
    public $courses = [];
    public $course_id = null;
    public $batches = [];
    public $batch_id = null;

    public $types = ['course' => 'كورس', 'session' => 'دورة', 'workshop' => 'ورشه'];
    public $durations = ['hour' => 'ساعه', 'day' => 'يوم'];
    public bool $batchCertificationPayments = false;
    public $certifications;

    public function mount()
    {
        $this->courses = \App\Models\Course::all()->pluck('arabic_name', 'id');
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "delete",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function resetData()
    {
        $this->reset('batchCertificationPayments', 'batch_id');
    }

    #[Title("الشهادات")]
    public function render()
    {

        if ($this->course_id != null) {
            $this->batches = \App\Models\Batch::where('course_id', $this->course_id)->pluck('start_date', 'id');
            if ($this->batch_id != null) {
                $rows = \App\Models\BatchStudent::where('batch_id', $this->batch_id)->whereNotNull('certification_id')->where('certification_id', '!=', 0)->paginate(10);
            } else {
                $rows = \App\Models\BatchStudent::whereHas('batch', function ($query) {
                    $query->where('course_id', $this->course_id);
                })->whereNotNull('certification_id')->where('certification_id', '!=', 0)->paginate(10);
            }
        } else {
            $rows = \App\Models\BatchStudent::whereNotNull('certification_id')->where('certification_id', '!=', 0)->paginate(10);
        }
        return view('livewire.certification', [
            'rows' => $rows,
        ]);
    }
}
