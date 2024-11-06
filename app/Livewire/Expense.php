<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Expense extends Component
{
    #[Title('المصروفات')]
    public function render()
    {
        return view('livewire.expense');
    }
}
