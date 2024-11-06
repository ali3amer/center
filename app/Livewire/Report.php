<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Report extends Component
{
    #[Title('التقارير')]
    public function render()
    {
        return view('livewire.report');
    }
}
