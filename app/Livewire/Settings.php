<?php

namespace App\Livewire;

use App\Models\Safe;
use Illuminate\Support\Facades\Artisan;
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
            $this->initial_balance = number_format(round($safe->initial_balance));
            $this->date = $safe->date;
        }
    }

    public function editSafe()
    {
        Safe::first()->update([
            'initial_balance' => round($this->initial_balance, 2),
            'date' => $this->date
        ]);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        $this->dispatch('update-balance');
    }

    public function dbBackup()
    {
        Artisan::call("backup:run  --only-db");
        $this->alert('success', 'تم النسخ الإحتياطي بنجاح', ['timerProgressBar' => true]);
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
