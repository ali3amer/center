<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Employee extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    protected $listeners = [
        'delete',
    ];
    public $headers = ['الإسم', 'البريد', 'الهاتف', 'العنوان'];
    public $cells = ['name', 'phone', 'email', 'salary'];
    public $id = 0;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $name = '';
    public $email = '';
    public $phone = '';
    public $position = '';
    public $salary = 0;
    public $search = '';

    public function save()
    {
        $this->validate();

        if ($this->id == 0) {
            \App\Models\Employee::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position' => $this->position,
                'salary' => $this->salary,
            ]);
        } else {
            \App\Models\Employee::where('id', $this->id)->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position' => $this->position,
                'salary' => $this->salary,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($employee) {
        $this->id = $employee['id'];
        $this->name = $employee['name'];
        $this->email = $employee['email'];
        $this->phone = $employee['phone'];
        $this->position = $employee['position'];
        $this->salary = $employee['salary'];
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
        \App\Models\Employee::where('id',$data['inputAttributes']['id'])->delete();
        $this->resetData();

        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('name', 'email', 'phone', 'position', 'salary', 'id', 'search');
    }

    #[Title('الموظفين')]
    public function render()
    {
        return view('livewire.employee', [
            'employees' => \App\Models\Employee::where('name', "like", '%' . $this->search . '%')->paginate(10)
        ]);
    }
}
