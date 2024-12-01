<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function batchStudent()
    {
        return $this->belongsTo(BatchStudent::class);
    }
}
