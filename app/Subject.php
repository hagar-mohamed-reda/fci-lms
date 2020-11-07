<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'name', 'code','doc_id','description','hours','notes'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doc_id');
    }

    public function lessons(){
        return $this->hasMany(Lesson::class, 'sbj_id');
    }

    /*public function students(){
        return $this->belongsToMany(Student::class,'student_id', 'subject_id')
                                    ->using(StudentSubject::class,'student_id', 'subject_id');
    }*/

    public function stdSbjs(){
        return $this->hasMany(StudentSubject::class,'subject_id');
    }

    /*public function ordersRegist(){
        return $this->belongsToMany(OrderRegist::class,'subject_id','order_id');
    }*/
}
