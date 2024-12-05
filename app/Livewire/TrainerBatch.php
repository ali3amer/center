<?php

namespace App\Livewire;

use App\Models\BatchTrainerPayment;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TrainerBatch extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $trainer_id;
    public $batch_id = null;
    public $certification_price = 0;
    public $price = 0;
    public $studentCount = 0;
    public $cost = 0;
    public $center_fees = 0;
    public $trainer_fees = 0;
    public $certificate_price = 0;
    public $required = 0;
    public $paid = 0;
    public $remainder = 0;
    public $certificate_cost = 0;
    public bool $trainerPaymentMode = false;
    public $search = '';

    public $headers = ['إسم البرنامج', 'تاريخ البداية', 'تاريخ النهاية', 'مكتمل', 'عدد الدارسين'];
    public $cells = ['courseName' => 'courseName', 'start_date' => 'start_date', 'end_date' => 'end_date', 'completed' => [true => 'نعم', false => 'لا'], 'studentCount'];
    #[On('update-trainer')]
    public function updatePrices($batch_id)
    {
        $this->dispatch('$refresh');
        $batch = \App\Models\Batch::find($batch_id);
        $this->choose($batch);
    }

    public function choose(\App\Models\Batch $batch)
    {
        $this->trainerPaymentMode = true;
        $this->batch_id = $batch['id'];
    }

    public function resetData()
    {
        $this->reset('trainerPaymentMode', 'certificate_price', 'price', 'studentCount', 'cost', 'center_fees', 'trainer_fees', 'certificate_cost', 'required');
    }

    public function render()
    {
        return view('livewire.trainer-batch', [
            'batches' => \App\Models\Batch::where('trainer_id', $this->trainer_id)->paginate(10)
        ]);
    }
}
