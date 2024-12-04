<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class BatchStudentPayment extends Model
{
    use HasFactory;
    public $guarded = [];

    public function batchStudent()
    {
        return $this->belongsTo(BatchStudent::class);
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
