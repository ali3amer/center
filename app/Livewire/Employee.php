<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Employee extends Component
{
    #[Title('الموظفين')]
    public function render()
    {
        return view('livewire.employee');
    }
}
