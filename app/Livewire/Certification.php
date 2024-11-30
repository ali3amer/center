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

    public $headers = ['الإسم بالعربي', 'نوع البرنامج', 'نوع المده', 'المده'];
    public $cells = ['arabic_name' => 'arabic_name', 'type' => 'type', 'duration' => 'duration', 'duration_value' => 'duration_value'];
    protected $listeners = [
        'delete',
    ];

    public $search = '';
    public $functions = [
        'courses' => ['chooseCourse'],
        'batches' => ['chooseBatch'],
        'batch_students' => []
    ];
    public $key = 'courses';
    public $course = [];
    public $batch = [];

    public $types = ['course' => 'كورس', 'session' => 'دورة', 'workshop' => 'ورشه'];
    public $durations = ['hour' => 'ساعه', 'day' => 'يوم'];

    public function mount()
    {
        $this->cells['type'] = $this->types;
        $this->cells['duration'] = $this->durations;
    }

    public function chooseCourse($course)
    {
        $this->key = 'batches';
        $this->course = $course;
        $this->headers = ['المدرب', 'تاريخ البداية', 'تاريخ النهاية', 'مكتمل', 'عدد الدارسين'];
        $this->cells = ['name' => 'name', 'start_date' => 'start_date', 'end_date' => 'end_date', 'completed' => [true => 'نعم', false => 'لا'], 'studentCount'];
    }

    public function chooseBatch($batch)
    {
        $this->batch = $batch;
        $this->key = 'batch_students';
        $this->headers = ['الإسم بالعربي', 'الإسم بالإنجليزي', 'تاريخ التسجيل'];
        $this->cells = ['arabic_name', 'english_name', 'date'];
    }

    public function resetCourse()
    {
        $this->key = 'courses';
        $this->course = [];
        $this->batch = [];
    }

    public function resetBatch()
    {
        $this->key = 'batches';
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

    #[Title("الشهادات")]
    public function render()
    {
        if ($this->key == 'courses') {
            $query = \App\Models\Course::where('arabic_name', 'like', '%' . $this->search . '%')->paginate(10);
        } elseif ($this->key == 'batches') {
            $query = \App\Models\Batch::where('course_id', $this->course['id'])->paginate(10);
        } elseif ($this->key == 'batch_students') {
            $query = \App\Models\BatchStudent::where('batch_id', $this->batch['id'])->join('students', 'students.id', '=', 'batch_students.student_id')->select('students.*', 'batch_students.*')->where('students.arabic_name', 'like', '%' . $this->search . '%')->paginate(10);
        }
        return view('livewire.certification', [
            'rows' => $query,
        ]);
    }
}
