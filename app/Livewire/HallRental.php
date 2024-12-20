<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class HallRental extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $headers = ['الجهه', 'نوع المؤجر', 'من', 'الى', 'المده', 'السعر', 'التكلفه'];
    public $cells = ['name', 'rentType', 'start_date', 'end_date', "duration", "price", 'cost'];
    public $numbers = ['price', 'cost'];
    protected $listeners = [
        'delete',
    ];
    public $hall_id;
    public $id = null;
    public $name = '';
    public $type = 'organization';
    public $duration_type = 'day';
    public $duration_types = ['day' => 'ايام', 'hour' => 'ساعات'];
    public $types = ['organization' => 'منظمه', 'government_institution' => 'حكومي', 'prison' => 'شخصي'];
    public $price = 0;
    public $start_date = '';
    public $end_date = '';
    public $duration = 0;
    public $cost = 0;
    public bool $completed = false;
    public bool $rentalPaymentMode  = false;
    public $hall_rental_id = null;
    public $remainder = 0;

    public function save()
    {
        if ($this->id == null) {
            \App\Models\HallRental::create([
                'hall_id' => $this->hall_id,
                'name' => $this->name,
                'type' => $this->type,
                'duration_type' => $this->duration_type,
                'duration' => $this->duration,
                'price' => round(floatval($this->price)),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'completed' => $this->completed,
            ]);
        } else {
            \App\Models\HallRental::where('id', $this->id)->update([
                'name' => $this->name,
                'type' => $this->type,
                'duration_type' => $this->duration_type,
                'duration' => $this->duration,
                'price' => round(floatval($this->price)),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'completed' => $this->completed,
            ]);
        }
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        $this->resetData();
    }

    public function edit($hallRental)
    {
        $this->id = $hallRental['id'];
        $this->name = $hallRental['name'];
        $this->type = $hallRental['type'];
        $this->duration_type = $hallRental['duration_type'];
        $this->duration = $hallRental['duration'];
        $this->price = round($hallRental['price']);
        $this->start_date = $hallRental['start_date'];
        $this->end_date = $hallRental['end_date'];
        $this->completed = $hallRental['completed'];
        $this->cost = round($this->duration * $this->price);
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "delete",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function delete($data)
    {
        \App\Models\HallRental::where('id', $data['inputAttributes']['id'])->delete();
        $this->resetData();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
        $this->resetData();
    }

    public function resetData()
    {
        $this->reset('name', 'type', 'duration_type', 'price', 'duration', 'cost', 'id', 'start_date', 'end_date', 'completed', 'rentalPaymentMode', 'remainder');
    }

    public function choose($hallRental)
    {
        $this->rentalPaymentMode = true;
        $this->hall_rental_id = $hallRental['id'];
        $this->edit($hallRental);
    }

    #[On('update-hall')]
    public function render()
    {
        if ($this->start_date == '') {
            $this->start_date = date('Y-m-d');
        }
        if ($this->end_date == '')
        {
            $this->end_date = date('Y-m-d');
        }
        $this->cost = $this->duration * $this->price;
        if ($this->hall_rental_id != null && $this->cost != 0) {
            $this->remainder = round(floatval($this->cost) - \App\Models\HallRentalPayment::where('hall_rental_id', $this->hall_rental_id)->sum('amount'));
        }
        return view('livewire.hall-rental', [
            'hallRentals' => \App\Models\HallRental::where('hall_id', $this->hall_id)
                ->paginate(10),
        ]);
    }
}
