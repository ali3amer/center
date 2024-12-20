<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Hall extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['الإسم', 'عدد الكراسي', 'السعر'];
    public $cells = ['name' => 'name', 'chairs' => 'chairs', 'price' => 'price'];
    public $numbers = ['price'];
    protected $listeners = [
        'delete',
    ];
    public $id = null;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $name = '';
    public $price = 0;
    public $chairs = 0;
    public $search = '';
    public bool $rentalMode = false;
    public $hall_id = null;

    public function save()
    {
        if ($this->id == null) {
            $this->validate();
            $hall = \App\Models\Hall::create([
                'name' => $this->name,
                'price' => round(floatval($this->price)),
                'chairs' => $this->chairs,
            ]);
            $this->resetData();

            $this->choose($hall);
        } else {
            \App\Models\Hall::where('id', $this->id)->update([
                'name' => $this->name,
                'price' => round(floatval($this->price)),
                'chairs' => $this->chairs,
            ]);
            $this->resetData();

        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($hall)
    {
        $this->id = $hall['id'];
        $this->name = $hall['name'];
        $this->price = round($hall['price']);
        $this->chairs = $hall['chairs'];
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
        \App\Models\Hall::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('name', 'price', 'chairs', 'id', 'search', 'rentalMode');
    }

    public function choose($hall)
    {
        $this->hall_id = $hall['id'];
        $this->edit($hall);
        $this->rentalMode = true;

    }
    #[Title('القاعات')]
    public function render()
    {
        return view('livewire.hall', [
            'halls' => \App\Models\Hall::where('name', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }
}
