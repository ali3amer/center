<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Trainer extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['الإسم بالعربي', 'الجنس', 'الهاتف'];
    public $cells = ['arabic_name' => 'arabic_name', 'gender' => 'gender', 'phone' => 'phone'];
    protected $listeners = [
        'delete',
    ];
    public $id = 0;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $arabic_name = '';
    public $english_name = '';
    public $national_id = '';
    public $gender = 'male';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $image = '';
    public $genders = ['male' => 'ذكر', 'female' => 'انثى'];
    public $search = '';

    public function mount()
    {
        $this->cells['gender'] = $this->genders;
    }

    public function save()
    {
        if ($this->id == 0) {
            $this->validate();
            \App\Models\Trainer::create([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
            ]);
        } else {
            \App\Models\Trainer::where('id', $this->id)->update([
                'arabic_name' => $this->arabic_name,
                'english_name' => $this->english_name,
                'national_id' => $this->national_id,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'image' => $this->image,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($trainer)
    {
        $this->id = $trainer['id'];
        $this->arabic_name = $trainer['arabic_name'];
        $this->english_name = $trainer['english_name'];
        $this->national_id = $trainer['national_id'];
        $this->gender = $trainer['gender'];
        $this->phone = $trainer['phone'];
        $this->email = $trainer['email'];
        $this->address = $trainer['address'];
        $this->image = $trainer['image'];
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
        \App\Models\Trainer::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('arabic_name', 'english_name', 'national_id', 'gender', 'phone', 'email', 'address', 'image', 'id', 'search');
    }
    #[Title('المدربين')]
    public function render()
    {
        return view('livewire.trainer', [
            'trainers' => \App\Models\Trainer::where('arabic_name', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }
}
