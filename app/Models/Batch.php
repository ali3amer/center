<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function batchStudents()
    {
        return $this->hasMany(BatchStudent::class);
    }

    public function batchTrainerPayments()
    {
        return $this->hasMany(BatchTrainerPayment::class);
    }

    public function batchCertificationPayments()
    {
        return $this->hasMany(BatchCertificationPayment::class);
    }
    public function getNameAttribute()
    {
        return $this->trainer->arabic_name;
    }
    public function getCourseNameAttribute()
    {
        return $this->course->arabic_name;
    }

    public function getStudentCountAttribute()
    {
        return $this->batchStudents()->count();
    }
    public function getcertificationsCountAttribute()
    {
        return $this->batchStudents->where('want_certification', true)->count();
    }

    public function getCourseTypeAttribute()
    {
        $type = $this->course->type;
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
        return Carbon::parse($this->start_date)->locale('ar')->translatedFormat('F');
    }

}
