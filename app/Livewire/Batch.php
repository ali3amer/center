<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Batch extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['المدرب', 'السعر', 'تاريخ البداية', 'تاريخ النهاية', 'مدفوعه', 'مكتمل', 'عدد الدارسين'];
    public $cells = ['name' => 'name', 'price' => 'price', 'start_date' => 'start_date', 'end_date' => 'end_date', 'paid' => [true => 'مدفوعه', false => 'مجانية'], 'completed' => [true => 'نعم', false => 'لا'], 'studentCount'];
    public $numbers = ['price'];
    public $functions = [];
    protected $listeners = [
        'delete',
    ];
    public $id = null;
    public $course_id;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $trainer_id;
    public $start_date = '';
    public $end_date = '';
    public $price = 0;
    public $certificate_price = 0;
    public $center_fees = 60;
    public $trainer_fees = 40;
    public bool $completed = false;
    public bool $paid = true;
    public array $trainers = [];
    public $fees = 0;

    public function mount()
    {
        $this->trainers = \App\Models\Trainer::pluck('arabic_name', 'id')->toArray();
        $this->price = round(\App\Models\Course::find($this->course_id)->price);
    }

    public function save()
    {
        $this->validate();
        if ($this->id == null) {
            \App\Models\Batch::create([
                'course_id' => $this->course_id,
                'trainer_id' => $this->trainer_id,
                'start_date' => $this->start_date,
                'center_fees' => $this->center_fees,
                'trainer_fees' => $this->trainer_fees,
                'end_date' => $this->end_date,
                'paid' => $this->paid,
                'price' => $this->price,
                'certificate_price' => $this->certificate_price,
            ]);
        } else {
            \App\Models\Batch::where('id', $this->id)->update([
                'course_id' => $this->course_id,
                'trainer_id' => $this->trainer_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'center_fees' => $this->center_fees,
                'trainer_fees' => $this->trainer_fees,
                'paid' => $this->paid,
                'price' => $this->price,
                'certificate_price' => $this->certificate_price,
            ]);
        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        $this->resetData();
    }

    public function edit($batch)
    {
        $this->id = $batch['id'];
        $this->trainer_id = $batch['trainer_id'];
        $this->start_date = $batch['start_date'];
        $this->end_date = $batch['end_date'];
        $this->paid = $batch['paid'];
        $this->center_fees = $batch['center_fees'];
        $this->trainer_fees = $batch['trainer_fees'];
        $this->price = round($batch['price']);
        $this->certificate_price = round($batch['certificate_price']);
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
        \App\Models\Batch::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('trainer_id', 'start_date', 'end_date', 'completed', 'paid', 'price', 'certificate_price', 'id', 'fees');
    }

    public function changeStatus($batch)
    {
        $this->completed = $batch['completed'];
        \App\Models\Batch::find($batch['id'])->update([
            'completed' => !$this->completed,
        ]);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function calc()
    {
        if ($this->paid) {
            $this->fees = round((floatval($this->price) - floatval($this->certificate_price)) * $this->center_fees / 100);
        }
    }

    public function render()
    {
//        if ($this->paid) {
//            $this->fees = (floatval($this->price) - floatval($this->certificate_price)) * $this->center_fees/100;
//        }

        if ($this->start_date == '') {
            $this->start_date = date('Y-m-d');
        }

        if ($this->end_date == '') {
            $this->end_date = date('Y-m-d');
        }
        $batches = \App\Models\Batch::where('course_id', $this->course_id);
        $this->functions = [];
        foreach ($batches->get() as $batch) {
            $this->functions[$batch->id][] = [
                'name' => 'changeStatus',
                'color' => $batch->completed ? 'bg-red-600' : 'bg-cyan-600',
                'icon' => true,
                'iconName' => $batch->completed ? 'fa-lock' : 'fa-lock-open',
                'text' => '',
            ];
        }
        return view('livewire.batch', [
            'batches' => $batches->paginate(10),
        ]);
    }
}
