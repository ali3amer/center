<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class User extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'delete',
    ];

    public $headers = ['الإسم', 'إسم الدخول'];
    public $cells = ['name', 'username'];

    public $id = null;
    public $username = '';
    public $name = '';
    public $password = '';
    public $search = '';

    protected function rules()
    {
        return [
            'username' => 'required|unique:users,username,' . $this->id
        ];
    }

    protected function messages()
    {
        return [
            'username.required' => 'الرجاء إدخال إسم المستخدم',
            'username.unique' => 'هذا المستخدم موجود مسبقاً'
        ];
    }


    public function save()
    {
        if ($this->id == null) {
            $this->validate();
            \App\Models\User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);
        } else {
            $user = \App\Models\User::find($this->id);
            $user->name = $this->name;
            $user->username = $this->username;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($user)
    {
        $this->id = $user['id'];
        $this->name = $user['name'];
        $this->username = $user['username'];
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
        \App\Models\User::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('name', 'username', 'password', 'id', 'search');
    }
    #[Title('المستخدمين')]
    public function render()
    {
        return view('livewire.user', [
            'users' => \App\Models\User::where('name', 'like', '%'.$this->search.'%')->where("id", "!=", 1)->where('id', '!=', auth()->id())->paginate(10)
        ]);
    }
}
