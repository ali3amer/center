<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchStudentPayment extends Model
{
    use HasFactory;
    public $guarded = [];

    public function batchStudent()
    {
        return $this->belongsTo(BatchStudent::class);
    }

}
