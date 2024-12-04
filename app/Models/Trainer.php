<?php

namespace App\Models;

use App\Livewire\TrainerPayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

}
