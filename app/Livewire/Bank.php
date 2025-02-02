<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Bank extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['إسم البنك', 'إسم صاحب الحساب', 'الرصيد الافتتاحي', 'الرصيد الحالي', 'التاريخ'];
    public $cells = ['bank_name', 'name', 'initial_balance', 'balance', 'date'];
    public $numbers = ['initial_balance', 'balance'];
    protected $listeners = [
        'delete',
    ];
    public $id = null;
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $bank_name = '';
    #[Rule('required', message: 'هذا الحقل مطلوب')]
    public $name = '';
    public $account_number = null;
    public $initial_balance = 0;
    public $date = '';

    public function save()
    {
        $this->validate();
        if ($this->id == null) {
            \App\Models\Bank::create([
                'bank_name' => $this->bank_name,
                'name' => $this->name,
                'account_number' => $this->account_number,
                'initial_balance' => round(floatval($this->initial_balance)),
                'date' => $this->date,
            ]);
        } else {
            \App\Models\Bank::where('id', $this->id)->update([
                'bank_name' => $this->bank_name,
                'name' => $this->name,
                'account_number' => $this->account_number,
                'initial_balance' => round(floatval($this->initial_balance)),
                'date' => $this->date,
            ]);
        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        $this->resetData();
    }

    public function edit($bank)
    {
        $this->id = $bank['id'];
        $this->bank_name = $bank['bank_name'];
        $this->name = $bank['name'];
        $this->account_number = $bank['account_number'];
        $this->initial_balance = round($bank['initial_balance']);
        $this->date = $bank['date'];
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
        \App\Models\Bank::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset('id', 'bank_name', 'name', 'initial_balance', 'account_number', 'date');
    }

    #[Title('البنوك')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.bank', [
            'banks' => \App\Models\Bank::paginate(10),
        ]);
    }
}
