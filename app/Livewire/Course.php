<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Course extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['الإسم بالعربي', 'نوع البرنامج', 'نوع المده', 'المده'];
    public $cells = ['arabic_name' => 'arabic_name', 'type' => 'type', 'duration' => 'duration', 'duration_value' => 'duration_value'];
    protected $listeners = [
        'delete',
    ];
    public $id = 0;
    public $course_id = null;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $arabic_name = '';
    public $english_name = '';
    public $type = 'course';
    public $price = 0;
    public $duration = 'hour';
    public $duration_value = 0;
    public $search = '';

    public $types = ['course' => 'كورس', 'session' => 'دورة', 'workshop' => 'ورشه'];
    public $durations = ['hour' => 'ساعه', 'day' => 'يوم'];
    public bool $batchMode = false;

    public function mount()
    {
        $this->cells['type'] = $this->types;
        $this->cells['duration'] = $this->durations;
    }
    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\Course::create([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'type' => $this->type,
                'price' => floatval($this->price),
                'duration' => $this->duration,
                'duration_value' => floatval($this->duration_value),
            ]);
        } else {
            \App\Models\Course::where('id', $this->id)->update([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'type' => $this->type,
                'price' => floatval($this->price),
                'duration' => $this->duration,
                'duration_value' => floatval($this->duration_value),
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function edit($course)
    {
        $this->id = $course['id'];
        $this->arabic_name = $course['arabic_name'];
        $this->english_name = $course['english_name'];
        $this->type = $course['type'];
        $this->price = $course['price'];
        $this->duration = $course['duration'];
        $this->duration_value = $course['duration_value'];
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
        \App\Models\Course::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('arabic_name', 'english_name', 'type', 'price', 'duration', 'duration_value', 'id', 'search', 'course_id', 'batchMode');
    }

    public function choose($course)
    {
        $this->course_id = $course['id'];
        $this->batchMode = true;
        $this->edit($course);
    }
    #[Title('البرامج التدريبية')]
    public function render()
    {
        return view('livewire.course', [
            'courses' => \App\Models\Course::where('arabic_name', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }
}
