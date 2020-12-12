<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $guarded = [];
    protected $table = "lms_student_assignments";

    protected $fillable = [
        'assign_id', 'student_id','pdf_anss','lesson_id', 'sbj_id','doc_id','grade',
    ];

    public function assignments(){
        return $this->belongsTo(Assignment::class,'assign_id');
    }

    public function students(){
        return $this->belongsTo(Student::class,'student_id');
    }

    public function subjects(){
        return $this->belongsTo(Subject::class,'sbj_id');
    }
}
