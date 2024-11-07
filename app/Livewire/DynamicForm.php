<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicForm extends Component
{
    public $fields = [];      // الحقول وأحجامها
    public $formData = [];    // القيم المدخلة في الحقول

    public function mount($fields)
    {
        $this->fields = $fields;
    }

    public function submit()
    {
        // منطق المعالجة للبيانات هنا
    }

    public function render()
    {
        return view('livewire.dynamic-form');
    }
}
