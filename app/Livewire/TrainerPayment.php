<?php

namespace App\Livewire;

use Livewire\Component;

class TrainerPayment extends Component
{
    public $trainer_id;
    public function render()
    {
        return view('livewire.trainer-payment');
    }
}
