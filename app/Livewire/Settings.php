<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Settings extends Component
{
    #[Title('الإعدادات')]
    public function render()
    {
        return view('livewire.settings');
    }
}
