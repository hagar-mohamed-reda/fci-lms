<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    protected $guarded = [];
    protected $table = "student_courses";

    protected $fillable = [
        'subject_id', 'student_id',
    ];

    public function subjects(){
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function students(){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function lessons(){
        return $this->hasMany(Lesson::class,'student_id');
    }
}
