<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Student extends Component
{
    public $arabic_name;
    public $english_name;
    public $national_id;
    public $gender;
    public $phone;
    public $email;
    public $address;
    public $image;



    #[Title('الطلاب')]
    public function render()
    {
        return view('livewire.student');
    }
}
