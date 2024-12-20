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
    public $cells = ['studentNumber', 'certification_id', 'arabic_name', 'english_name', 'courseName', 'courseType', 'month'];
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
        $this->certifications = \App\Models\Certification::all();
    }

    public function chooseCourse()
    {
        if ($this->course_id != null) {
            $this->batches = \App\Models\Batch::where('course_id', $this->course_id)->pluck('start_date', 'id');
            $this->certifications = \App\Models\Certification::whereHas('batchStudent.batch', function ($query) {
                $query->where('course_id', $this->course_id);
            })->get();
        } else {
            $this->certifications = \App\Models\Certification::all();
        }
    }

    public function chooseBatch()
    {
        if ($this->batch_id != null) {
            $this->certifications = \App\Models\Certification::whereHas('batchStudent', function ($query) {
                $query->where('batch_id', $this->batch_id);
            })->get();
        } else {
            $this->chooseCourse();
        }
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
        $this->reset('batchCertificationPayments');
    }

    #[Title("الشهادات")]
    public function render()
    {
        return view('livewire.certification', [
            'rows' => $this->certifications,
        ]);
    }
}
