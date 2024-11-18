<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallRental extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCostAttribute()
    {
        return $this->cost = $this->price * $this->duration;
    }
}
