<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class User extends Component
{
public $name;
public $email;
public $phone;

    public function change()
    {
        dd($this->name);
}
    public function save()
    {
        sleep(1000000);

        dd(2);
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
