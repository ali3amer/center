<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Transfer extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['البنك', 'نوع العملية', 'المبلغ', 'رقم العملية', 'التاريخ'];
    public $cells = ['name' => 'name', 'transfer_type' => 'transfer_type', 'amount' => 'amount', 'transaction_id' => 'transaction_id', 'date' => 'date'];

    protected $listeners = [
        'delete',
    ];
    public $id = null;
    public $transfer_type = 'cash_to_bank';
    public $bank_id = null;
    public $transfer_types = [
        'cash_to_bank' => 'من الخزنه الى البنك',
        'bank_to_cash' => 'من البنك الى الخزنه'
    ];
    public $amount = '';
    public $transaction_id = '';
    public $date = '';
    public $banks = [];

    public function mount()
    {
        $this->banks = \App\Models\Bank::pluck('bank_name', 'id')->toArray();
        $this->cells['transfer_type'] = $this->transfer_types;
    }

    public function save()
    {
        if ($this->id == null) {
            \App\Models\Transfer::create([
                'bank_id' => $this->bank_id,
                'transfer_type' => $this->transfer_type,
                'amount' => $this->amount,
                'transaction_id' => $this->transaction_id,
                'date' => $this->date,
                'user_id' => Auth::id(),
            ]);
        } else {
            \App\Models\Transfer::where('id', $this->id)->update([
                'bank_id' => $this->bank_id,
                'transfer_type' => $this->transfer_type,
                'amount' => $this->amount,
                'transaction_id' => $this->transaction_id,
                'date' => $this->date,
                'user_id' => Auth::id(),
            ]);
        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        $this->resetData();
    }

    public function edit($transfer)
    {
        $this->id = $transfer['id'];
        $this->transfer_type = $transfer['transfer_type'];
        $this->amount = $transfer['amount'];
        $this->transaction_id = $transfer['transaction_id'];
        $this->date = $transfer['date'];
        $this->bank_id = $transfer['bank_id'];
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
        \App\Models\Transfer::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->dispatch('update-balance');

        $this->reset('id', 'transfer_type', 'amount', 'transaction_id', 'date');
    }
    #[Title('التحويلات')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.transfer', [
            'transfers' => \App\Models\Transfer::paginate(10)
        ]);
    }
}
