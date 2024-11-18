<?php

namespace App\Livewire;

use Livewire\Component;

class BatchStudent extends Component
{
    public $student_id;
    public $id = null;


    public function render()
    {
        return view('livewire.batch-student', [
            'batch_students' => \App\Models\BatchStudent::where('student_id', $this->student_id)->get()
        ]);
    }
}
