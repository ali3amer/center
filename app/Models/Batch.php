<?php

namespace App\Models;

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

    public function getNameAttribute()
    {
        return $this->trainerName = $this->trainer->arabic_name;
    }

    public function getStudentCountAttribute()
    {
        return $this->batchStudents()->count();
    }

}
