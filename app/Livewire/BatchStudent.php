<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BatchStudent extends Component
{

    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['الدفعه', 'تاريخ التسجيل'];
    public $cells = ['batch_id' => 'arabic_name', 'date' => 'date'];
    protected $listeners = [
        'delete',
    ];
    public $student_id;
    public $id = null;
    public $batch_id = null;
    public $date = '';
    public $batches = [];
    public bool $batchStudentPaymentMode = false;
    public $batch_student_id = null;

    public function mount()
    {
        $this->batches = \App\Models\Batch::where("completed", false)->join('courses', 'batches.course_id', '=', 'courses.id')->select('batches.*', 'courses.arabic_name')->pluck('arabic_name', 'id')->toArray();
        $this->cells['batch_id'] = $this->batches;
    }
    public function save()
    {
        if ($this->id == null) {
            \App\Models\BatchStudent::create([
                'student_id' => $this->student_id,
                'batch_id' => $this->batch_id,
                'date' => $this->date,
            ]);
        } else {
            \App\Models\BatchStudent::where('id', $this->id)->update([
                'batch_id' => $this->batch_id,
                'date' => $this->date,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($batchStudent)
    {
        $this->id = $batchStudent['id'];
        $this->student_id = $batchStudent['student_id'];
        $this->batch_id = $batchStudent['batch_id'];
        $this->date = $batchStudent['date'];
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

    public function delete($data)
    {
        \App\Models\BatchStudent::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('batch_id','id','date', 'batchStudentPaymentMode');
    }

    public function choose($batchStudent)
    {
        $this->batch_student_id = $batchStudent['id'];
        $this->edit($batchStudent);
        $this->batchStudentPaymentMode = true;

    }

    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.batch-student', [
            'batchStudents' => \App\Models\BatchStudent::where('student_id', $this->student_id)->with("batch.course")->paginate(10)
        ]);
    }
}
