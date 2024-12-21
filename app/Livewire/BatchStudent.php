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

    public $headers = ['رقم الطالب', 'الدفعه', 'تاريخ التسجيل'];
    public $cells = ['student_number', 'course', 'date'];
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
    public $student_number = 0;
    public $remainder = 0;
    public $certification_id = 0;
    public $search = '';

    public function mount()
    {
        $this->batches = \App\Models\Batch::where("completed", false)->join('courses', 'batches.course_id', '=', 'courses.id')->select('batches.*', 'courses.arabic_name')->pluck('arabic_name', 'id')->toArray();
        $this->checkStudentNumber();
        $this->checkCertificationId();
    }

    public function checkStudentNumber()
    {
        $students = \App\Models\BatchStudent::count();
        if ($students > 0) {
            $this->student_number = \App\Models\BatchStudent::max('student_number') + 1;
        } else {
            $this->student_number = 1;
        }
    }

    public function checkCertificationId()
    {
        $certifications = \App\Models\BatchStudent::count();
        if ($certifications > 0) {
            $this->certification_id = \App\Models\BatchStudent::max('certification_id') + 1;
        } else {
            $this->certification_id = 1;
        }
    }

    public function save()
    {
        $check = \App\Models\BatchStudent::where('student_id', $this->student_id)->where('batch_id', $this->batch_id)->first();
        if ($check) {
            $this->confirm("هذا الطالب مسجل بهذا البرنامج مسبقاً", [
                'toast' => false,
                'showConfirmButton' => false,
                'confirmButtonText' => 'موافق',
                'onConfirmed' => "cancelSale",
                'showCancelButton' => true,
                'cancelButtonText' => 'إلغاء',
                'confirmButtonColor' => '#dc2626',
                'cancelButtonColor' => '#4b5563'
            ]);
        } else {
            $this->validate();
            if ($this->id == null) {
                $batch_student = \App\Models\BatchStudent::create([
                    'student_id' => $this->student_id,
                    'batch_id' => $this->batch_id,
                    'student_number' => round(floatval($this->student_number)),
                    'certification_id' => $this->want_certification ? round(floatval($this->certification_id)) : null,
                    'want_certification' => $this->want_certification,
                    'date' => $this->date,
                ]);

                $this->choose($batch_student);

            } else {
                $batch_student = \App\Models\BatchStudent::find($this->id);
                $batch_student->batch_id = $this->batch_id;
                $batch_student->date = $this->date;
                $this->student_number = round(floatval($batch_student->student_number));
                $this->certification_id = $this->want_certification ? round(floatval($this->certification_id)) : null;
                $batch_student->want_certification = $this->want_certification;
                $batch_student->save();
                $this->resetData();
            }
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        }

    }

    public function edit($batchStudent)
    {
        $this->id = $batchStudent['id'];
        $this->student_id = $batchStudent['student_id'];
        $this->batch_id = $batchStudent['batch_id'];
        $this->date = $batchStudent['date'];
        $this->student_number = round($batchStudent['student_number']);
        $this->certification_id = $batchStudent['certification_id'];
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

    public function resetData($data = null)
    {
        if ($data != null) {
            $this->reset($data);
        }
        $this->reset('batch_id', 'id', 'date', 'price', 'remainder', 'want_certification', 'certification_id', 'student_number');
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
            $this->price = round($batch->price);

            if ($this->batch_student_id != null) {
                $batch_student = \App\Models\BatchStudent::where("batch_id", $this->batch_id)->where("student_id", $this->student_id)->first()->id ?? null;
                if ($batch_student != null) {
                    $this->remainder = round(floatval($batch->price) - floatval(\App\Models\BatchStudentPayment::where("batch_student_id", $batch_student)->sum('amount')));
                }
            } else {
                $this->remainder = floatval($batch->price);
            }

            if ($this->paid) {
                $this->want_certification = true;
            }

            if (!$this->want_certification) {
                $this->certification_id = 0;
            }

            if ($this->want_certification && floatval($this->certification_id) == 0) {
                $this->checkCertificationId();
            }
        }

        if (floatval($this->student_number) == 0) {
            $this->checkStudentNumber();
        }

        return view('livewire.batch-student', [
            'batchStudents' => \App\Models\BatchStudent::where('student_id', $this->student_id)->with("batch.course")->paginate(10)
        ]);
    }
}
