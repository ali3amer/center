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
    public $headers = ['إسم البرنامج', 'تاريخ البداية', 'تاريخ النهاية', 'مكتمل', 'عدد الدارسين'];
    public $cells = ['courseName' => 'courseName', 'start_date' => 'start_date', 'end_date' => 'end_date', 'completed' => [true => 'نعم', false => 'لا'], 'studentCount'];

    #[On('update-trainer')]
    public function updatePrices($batch_id)
    {
        $batch = \App\Models\Batch::find($batch_id);
        $this->choose($batch);
    }
    public function choose(\App\Models\Batch $batch)
    {
        $this->trainerPaymentMode = true;
        $this->batch_id = $batch['id'];
        $this->trainer_id = $batch['trainer_id'];
        $this->certificate_price = $batch['certificate_price'];
        $this->price = $batch['price'];
        $this->studentCount = $batch->studentCount;
        $this->cost = $this->price * $this->studentCount;
        $this->center_fees = $batch['center_fees'];
        $this->trainer_fees = $batch['trainer_fees'];
        $this->paid = BatchTrainerPayment::where('batch_id', $batch['id'])->sum('amount');
        $this->certificate_cost = $this->certificate_price * \App\Models\BatchStudent::where('batch_id', $batch['id'])->where('want_certification', true)->count();
        $this->required = ($this->cost - $this->certificate_cost) * $this->trainer_fees / 100;
    }

    public function resetData()
    {
        $this->reset('trainerPaymentMode', 'certificate_price', 'price', 'studentCount', 'cost', 'center_fees', 'trainer_fees', 'certificate_cost', 'required');
    }

    public function render()
    {
        if ($this->batch_id != null) {
            $this->cost = $this->price * $this->studentCount;
            $this->remainder = $this->required - \App\Models\BatchTrainerPayment::where('batch_id', $this->batch_id)->sum('amount');
        }
        return view('livewire.trainer-batch', [
            'batches' => \App\Models\Batch::where('trainer_id', $this->trainer_id)->paginate(10)
        ]);
    }
}
