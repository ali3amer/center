<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Student extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $id = null;
    public $arabic_name = '';
    public $english_name = '';
    public $national_id = '';
    public $gender = 'male';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $image = null;

    public function save()
    {
        dd($this->arabic_name);
        if ($this->id == null) {
            \App\Models\Student::create([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'gender' => $this->gender,
            ]);
        } else {
            \App\Models\Student::where('id', $this->id)->update([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'gender' => $this->gender,
            ]);
        }
//        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

    }

    public function edit($student)
    {
        $this->id = $student->id;
        $this->arabic_name = $student->arabic_name;
        $this->english_name = $student->english_name;
        $this->national_id = $student->national_id;
        $this->gender = $student->gender;
        $this->phone = $student->phone;
        $this->email = $student->email;
        $this->address = $student->address;
    }

    public function chcek()
    {
        dd($this->arabic_name);
    }

    public function delete($id)
    {
        \App\Models\Student::where('id', '=', $id)->delete();
    }

    #[Title('الدارسين')]
    public function render()
    {
        return view('livewire.student');
    }
}
