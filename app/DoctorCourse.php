<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorCourse extends Model
{
    protected $table = "doctor_courses";

    protected $fillable = ['doctor_id', 'course_id' ];

    public function doctors(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function subjects(){
        return $this->belongsTo(Subject::class,'course_id');
    }

}
