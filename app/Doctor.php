<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Notifications\Notifiable;


class Doctor extends Model
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $guarded = [];

    protected $table = "doctors";

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'active',
        'active_code',
        'account_confirm'
    ];

    /*protected $casts = [
        'phone' => 'array'
    ];*/


    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function subjects(){
    //     return $this->hasMany(Subject::class, 'doc_id');
    // }
    public function lessons(){
        return $this->hasMany(Lesson::class, 'doc_id');
    }
    public function assignments(){
        return $this->hasMany(Assignment::class, 'doc_id');
    }

    public function docSubjs(){
        return $this->hasMany(DoctorCourse::class, 'doctor_id');
    }
}
