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
    public $numbers = ['amount'];
    protected $listeners = [
        'delete',
    ];
    public $id = null;
    public $transfer_type = 'cash_to_bank';
    public $bank_id = null;
    public bool $disabled = false;
    public $transfer_types = [
        'cash_to_bank' => 'من الخزنه الى البنك',
        'bank_to_cash' => 'من البنك الى الخزنه'
    ];
    public $amount = '';
    public $transaction_id = '';
    public $date = '';
    public $note = null;
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
                'amount' => round(floatval($this->amount)),
                'transaction_id' => $this->transaction_id,
                'date' => $this->date,
                'note' => $this->note,
                'user_id' => Auth::id(),
            ]);
        } else {
            \App\Models\Transfer::where('id', $this->id)->update([
                'bank_id' => $this->bank_id,
                'transfer_type' => $this->transfer_type,
                'amount' => round(floatval($this->amount)),
                'transaction_id' => $this->transaction_id,
                'date' => $this->date,
                'note' => $this->note,
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
        $this->amount = round(floatval($transfer['amount']));
        $this->transaction_id = $transfer['transaction_id'];
        $this->date = $transfer['date'];
        $this->note = $transfer['note'];
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

        $this->reset('id', 'transfer_type', 'amount', 'transaction_id', 'date', 'note');
    }
    #[Title('التحويلات')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }

        if ($this->transfer_type == null) {
            $this->transfer_type = 'cash_to_bank';
        }

        if (floatval($this->amount) == 0) {
            $this->disabled = true;
        } elseif ($this->transfer_type == 'cash_to_bank' && (floatval($this->amount) > session('cash_balance'))) {
            $this->disabled = true;
        } elseif ($this->transfer_type == 'bank_to_cash' && (floatval($this->amount) > session('bank_balance'))) {
            $this->disabled = true;
        } else {
            $this->disabled = false;
        }
        if (empty($this->banks)) {
            $this->disabled = true;
        }
        return view('livewire.transfer', [
            'transfers' => \App\Models\Transfer::paginate(10)
        ]);
    }
}
