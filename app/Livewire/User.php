<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class User extends Component
{
public $name;
public $email;
public $phone;
public $data = [];


    public function save()
    {

    }
    public function edit()
    {
        dd("edit");
    }
    public function delete()
    {
        dd(5);
    }
    #[Title('المستخدمين')]
    public function render()
    {
        return view('livewire.user');
    }
}
