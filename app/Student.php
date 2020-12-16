<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $guarded = [];
    protected $table = "students";

    /*protected $casts = [
        'phone' => 'array'
    ];*/


    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'code',
        'level_id',
        'department_id',
        'active',
        'active_code',
        'account_confirm',
        'set_number',
        'national_id',
        'graduated',
        'can_see_result',
    ];



    protected $hidden = [
        'password', 'remember_token',
    ];

    /*public function subjects(){
        return $this->belongsToMany(Subject::class,'student_id', 'subject_id')
                                    ->using(StudentSubject::class,'student_id', 'subject_id');
    }*/

    public function stdSbjs(){
        return $this->hasMany(StudentSubject::class,'student_id');
    }

    public function stdAssign(){
        return $this->hasMany(StudentAssignment::class,'student_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'fid');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function lessons(){
        return Lesson::whereIn('sbj_id', $this->stdSbjs()->pluck('course_id')->toArray());
    }

    public function assignments(){
        return Assignment::whereIn('sbj_id', $this->stdSbjs()->pluck('course_id')->toArray());
    }
    /*public function ordersRegits(){
        return $this->hasMany(OrderRegist::class,'student_id','order_id');
    }*/
}
