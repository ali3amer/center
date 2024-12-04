<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallRentalPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hallRental()
    {
        return $this->belongsTo(HallRental::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
