<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallRental extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function hallRentalPayments()
    {
        return $this->hasMany(HallRentalPayment::class);
    }

    public function getRentTypeAttribute()
    {
        if ($this->type == "organization") {
            $type = "منظمة";
        } elseif ($this->type == "government_institution") {
            $type = "حكومي";
        } else {
            $type = "شخصي";
        }
        return $type;
    }

    public function getCostAttribute()
    {
        return $this->cost = $this->price * $this->duration;
    }
}
