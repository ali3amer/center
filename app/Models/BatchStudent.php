<?php

namespace App\Models;

use Carbon\Carbon;
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
    public function getTrainerAttribute()
    {
        return $this->batch->name;
    }

    public function getCourseAttribute()
    {
        return $this->batch->courseName;
    }

    public function getCertificationPriceAttribute()
    {
        return $this->batch->certificate_price;
    }

    public function getCourseTypeAttribute()
    {
        $type = $this->batch->course->type;
        if ($type == 'course')
        {
            $course_type = 'كورس';
        } elseif ($type == 'session')
        {
            $course_type = 'دورة';
        } else {
            $course_type = 'ورشه';
        }
        return $course_type;
    }

    public function getMonthAttribute()
    {
        return Carbon::parse($this->batch->start_date)->locale('ar')->translatedFormat('F') . ' | ' . Carbon::parse($this->batch->start_date)->year;
    }


}
