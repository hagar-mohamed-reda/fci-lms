<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = "courses";

    protected $guarded = [];

    protected $fillable = [
        'name', 'code','hours','notes','level_id'
    ];

    // public function doctor(){
    //     return $this->belongsTo(Doctor::class, 'doc_id');
    // }

    public function lessons(){
        return $this->hasMany(Lesson::class, 'sbj_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function docSubjs(){
        return $this->hasMany(DoctorCourse::class, 'course_id');
    }

    /*public function students(){
        return $this->belongsToMany(Student::class,'student_id', 'subject_id')
                                    ->using(StudentSubject::class,'student_id', 'subject_id');
    }*/

    public function stdSbjs(){
        return $this->hasMany(StudentSubject::class,'course_id');
    }

    public function doctors() {
        return Doctor::whereIn('id', $this->docSubjs()->pluck('doctor_id')->toArray());
    }
    /*public function ordersRegist(){
        return $this->belongsToMany(OrderRegist::class,'subject_id','order_id');
    }*/

    public function hasDoctor($doctorId) {
        return DoctorCourse::where('doctor_id', $doctorId)->where('course_id', $this->id)->exists()? true : false;
    }

    public function hasStudent($studentId) {
        return StudentSubject::where('student_id', $studentId)->where('course_id', $this->id)->exists()? true : false;
    }
}
