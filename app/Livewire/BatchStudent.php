<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
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
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $batch_id = null;
    public $date = '';
    public bool $want_certification = false;
    public bool $paid = true;
    public $batches = [];
    public bool $batchStudentPaymentMode = false;
    public $batch_student_id = null;
    public $price = 0;
    public $remainder = 0;
    public $certification_id = 0;
    public $search = '';

    public function mount()
    {
        $this->batches = \App\Models\Batch::where("completed", false)->join('courses', 'batches.course_id', '=', 'courses.id')->select('batches.*', 'courses.arabic_name')->pluck('arabic_name', 'id')->toArray();
        $this->cells['batch_id'] = $this->batches;
    }

    public function save()
    {
        $this->validate();
        if ($this->id == null) {
            $batch_student = \App\Models\BatchStudent::create([
                'student_id' => $this->student_id,
                'batch_id' => $this->batch_id,
                'want_certification' => $this->want_certification,
                'date' => $this->date,
            ]);

            if ($this->want_certification) {
                \App\Models\Certification::create([
                    'batch_student_id' => $batch_student->id,
                    'certification_id' => $this->certification_id,
                ]);
            }

        } else {
            $batch_student = \App\Models\BatchStudent::find($this->id);
            $batch_student->batch_id = $this->batch_id;
            $batch_student->date = $this->date;
            $batch_student->want_certification = $this->want_certification;
            $batch_student->save();
            if (!$batch_student->certification) {
                \App\Models\Certification::where('batch_student_id', $batch_student->id)->delete();
            } else {
                $check = \App\Models\Certification::where("batch_student_id", $batch_student->id)->count();
                if ($check == 0) {
                    \App\Models\Certification::create([
                        'batch_student_id' => $batch_student->id,
                        'certification_id' => $this->certification_id,
                    ]);
                } else {
                    \App\Models\Certification::where('batch_student_id', $batch_student->id)->update([
                        'certification_id' => $this->certification_id,
                    ]);
                }
            }
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
        $this->certification_id = \App\Models\Certification::where("batch_student_id", $batchStudent['id'])->first()->certification_id ?? 0;
        $this->want_certification = $batchStudent['want_certification'];
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
        $this->reset('batch_id', 'id', 'date', 'batchStudentPaymentMode', 'price', 'remainder', 'want_certification', 'certification');
    }

    public function choose($batchStudent)
    {
        $this->batch_student_id = $batchStudent['id'];
        $this->edit($batchStudent);
        $this->batchStudentPaymentMode = true;

    }

    #[On('update-price')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }

        if ($this->batch_id != null) {
            $batch = \App\Models\Batch::find($this->batch_id);
            $this->paid = $batch->paid;
            $this->price = $batch->price;
            if ($this->batch_student_id != null) {
                $batch_student = \App\Models\BatchStudent::where("batch_id", $this->batch_id)->where("student_id", $this->student_id)->first()->id;
                $this->remainder = floatval($batch->price) - floatval(\App\Models\BatchStudentPayment::where("batch_student_id", $batch_student)->sum('amount'));
            }
            if ($this->paid) {
                $this->want_certification = true;
            }
            if (!$this->want_certification) {
             $this->certification_id = 0;
            }

            if ($this->want_certification && $this->certification_id == 0) {
                $this->certification_id = \App\Models\Certification::max('certification_id') + 1;
            }
        }
        return view('livewire.batch-student', [
            'batchStudents' => \App\Models\BatchStudent::where('student_id', $this->student_id)->with("batch.course")->paginate(10)
        ]);
    }
}
