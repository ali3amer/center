<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchTrainerPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function getNameAttribute()
    {
        return $this->batch->name;
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
