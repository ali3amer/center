<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];
    public $headers = ['name', 'email', 'phone', 'address'];
    public $cells = ['name', 'phone', 'email', 'salary'];
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $name = '';
    public $email = '';
    public $phone = '';
    public $position = '';
    public $salary = 0;
    public function save()
    {
        $this->validate();

        \App\Models\Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'salary' => $this->salary,
        ]);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }
    #[Title('الموظفين')]
    public function render()
    {
        return view('livewire.employee', [
            'employees' => \App\Models\Employee::all()
        ]);
    }
}
