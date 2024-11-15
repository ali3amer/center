<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Expense extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['البند', 'المبلغ', 'التاريخ'];
    public $cells = ['description' => 'description', 'amount' => 'amount', 'date' => 'date'];
    protected $listeners = [
        'delete',
    ];
    public $id = 0;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $description = '';
    public $amount = 0;
    public $date = '';
    public $search = '';

    public function save()
    {
        $this->validate();

        if ($this->id == 0) {
            \App\Models\Expense::create([
                'description' => $this->description,
                'amount' => floatval($this->amount),
                'date' => $this->date,
            ]);
        } else {
            \App\Models\Expense::where('id', $this->id)->update([
                'description' => $this->description,
                'amount' => floatval($this->amount),
                'date' => $this->date,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($expense)
    {
        $this->id = $expense['id'];
        $this->description = $expense['description'];
        $this->amount = $expense['amount'];
        $this->date = $expense['date'];
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
        \App\Models\Expense::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('description', 'amount', 'date', 'search', 'id');
    }
    #[Title('المصروفات')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.expense', [
            'expenses' => \App\Models\Expense::where('description', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }
}
