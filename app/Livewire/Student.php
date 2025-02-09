<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Student extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];

    public $headers = ['الإسم بالعربي', 'الهاتف'];
    public $cells = ['arabic_name' => 'arabic_name', 'phone' => 'phone'];

    public $id = null;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $arabic_name = '';
    public $english_name = '';
    public $national_id = '';
    public $gender = 'male';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $image = null;
    public $genders = ['male' => 'ذكر', 'female' => 'انثى'];
    public $search = '';
    public $batchMode = false;
    public $student_id = null;

    public function save()
    {
        if ($this->id == 0) {
            $this->validate();
            $student = \App\Models\Student::create([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
            ]);
            $this->resetData();
            $this->choose($student);
        } else {
            \App\Models\Student::where('id', $this->id)->update([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'image' => $this->image,
            ]);
            $this->resetData();

        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($Student)
    {
        $this->id = $Student['id'];
        $this->arabic_name = $Student['arabic_name'];
        $this->english_name = $Student['english_name'];
        $this->national_id = $Student['national_id'];
        $this->gender = $Student['gender'];
        $this->phone = $Student['phone'];
        $this->email = $Student['email'];
        $this->address = $Student['address'];
        $this->image = $Student['image'];
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
        \App\Models\Student::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('arabic_name', 'english_name', 'national_id', 'gender', 'phone', 'email', 'address', 'image', 'id', 'search', 'student_id', 'batchMode');
    }

    public function choose($student)
    {

        $this->batchMode = true;
        $this->student_id = $student['id'];
        $this->edit($student);
    }


    #[Title('الدارسين')]
    public function render()
    {
        return view('livewire.student', [
            'students' => \App\Models\Student::where('arabic_name', 'like', '%' . $this->search . '%')->paginate(10)
        ]);
    }
}
