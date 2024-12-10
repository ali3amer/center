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

    public function getArabicNameAttribute()
    {
        return $this->batchStudent->student->arabic_name;
    }

    public function getEnglishNameAttribute()
    {
        return $this->batchStudent->student->english_name;
    }

    public function getCourseNameAttribute()
    {
        return $this->batchStudent->batch->course->arabic_name;
    }

    public function getCourseTypeAttribute()
    {
        return $this->batchStudent->batch->courseType;
    }

    public function getMonthAttribute()
    {
        return $this->batchStudent->batch->month;
    }



}
