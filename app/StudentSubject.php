<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'subject_id', 'student_id',
    ];

    public function subjects(){
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function students(){
        return $this->belongsTo(Student::class,'student_id');
    }
}
