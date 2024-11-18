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

    public $headers = ['المدرب', 'تاريخ البداية', 'تاريخ النهاية', 'مكتمل'];
    public $cells = ['name' => 'name', 'start_date' => 'start_date', 'end_date' => 'end_date', 'completed' => [true => 'نعم', false => 'لا']];

    protected $listeners = [
        'delete',
    ];
    public $id = null;
    public $course_id;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $trainer_id;
    public $start_date;
    public $end_date;
    public bool $completed = false;
    public array $trainers = [];

    public function mount()
    {
        $this->trainers = \App\Models\Trainer::pluck('arabic_name', 'id')->toArray();
    }

    public function save()
    {
        $this->validate();
        if ($this->id == null) {
            \App\Models\Batch::create([
                'course_id' => $this->course_id,
                'trainer_id' => $this->trainer_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'completed' => $this->completed,
            ]);
        } else {
            \App\Models\Batch::where('id', $this->id)->update([
                'course_id' => $this->course_id,
                'trainer_id' => $this->trainer_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'completed' => $this->completed,
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
        $this->completed = $batch['completed'];
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
        $this->reset('trainer_id', 'start_date', 'end_date', 'completed', 'id');
    }

    public function render()
    {
        if ($this->start_date == '') {
            $this->start_date = date('Y-m-d');
        }

        if ($this->end_date == '') {
            $this->end_date = date('Y-m-d');
        }
        return view('livewire.batch', [
            'batches' => \App\Models\Batch::where('course_id', $this->course_id)->with('trainer')->paginate(10),
        ]);
    }
}
