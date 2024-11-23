<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
        }
        return view('livewire.navbar');
    }
}
