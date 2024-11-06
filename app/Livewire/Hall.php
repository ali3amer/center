<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Hall extends Component
{
    #[Title('القاعات')]
    public function render()
    {
        return view('livewire.hall');
    }
}
