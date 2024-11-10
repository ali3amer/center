<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicTable extends Component
{
    public $columns = [];  // أسماء الأعمدة المطلوبة
    public $data = [];     // البيانات لعرضها في الجدول

    public function mount($columns, $data)
    {
        $this->columns = $columns;
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.dynamic-table');
    }
}
