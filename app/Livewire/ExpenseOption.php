<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ExpenseOption extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['التصنيف'];
    public $cells = ['optionName'];
    protected $listeners = [
        'delete',
    ];
    public $id = null;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $optionName = '';
    public $search = '';

    public function save()
    {
        $this->validate();

        if ($this->id == null) {
            \App\Models\ExpenseOption::create([
                'optionName' => $this->optionName,
            ]);
        } else {
            \App\Models\ExpenseOption::where('id', $this->id)->update([
                'optionName' => $this->optionName,
            ]);
        }
        $this->resetData();
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function edit($expense)
    {
        $this->id = $expense['id'];
        $this->optionName = $expense['optionName'];
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
        \App\Models\ExpenseOption::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-expenses');
        $this->reset('optionName', 'search', 'id');
    }

    public function render()
    {
        return view('livewire.expense-option', [
            'expense_options' => \App\Models\ExpenseOption::where('optionName', 'like', '%'.$this->search.'%')->paginate(10)
        ]);
    }
}
