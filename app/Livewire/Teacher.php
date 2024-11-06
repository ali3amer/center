<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Teacher extends Component
{
    #[Title('المدربين')]
    public function render()
    {
        return view('livewire.teacher');
    }
}
