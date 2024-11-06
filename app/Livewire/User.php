<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class User extends Component
{

    #[Title('المستخدمين')]
    public function render()
    {
        return view('livewire.user');
    }
}
