<?php

namespace App\Livewire;

use App\Models\Safe;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class Settings extends Component
{
    use LivewireAlert;

    public $initial_balance = 0;
    public $date = '';

    public function mount()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        $safe = Safe::first();
        if ($safe == null) {
            Safe::create([
                'initial_balance' => 0,
                'date' => $this->date
            ]);
        } else {
            $this->initial_balance = $safe->initial_balance;
            $this->date = $safe->date;
        }
    }

    public function editSafe()
    {
        Safe::first()->update([
            'initial_balance' => floatval($this->initial_balance),
            'date' => $this->date
        ]);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        $this->dispatch('update-balance');
    }

    #[Title('الإعدادات')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.settings');
    }
}
