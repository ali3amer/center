<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Course extends Component
{
    #[Title('الكورسات')]
    public function render()
    {
        return view('livewire.course');
    }
}
