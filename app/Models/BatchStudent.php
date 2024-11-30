<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    use HasFactory;
    public $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function batchStudentPayments()
    {
        return $this->hasMany(BatchStudentPayment::class);
    }

    public function getNameAttribute()
    {
        return $this->student->arabic_name;
    }

}
