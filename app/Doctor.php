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


    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'active',
        'account_confirm'
    ];

    /*protected $casts = [
        'phone' => 'array'
    ];*/


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function subjects(){
        return $this->hasMany(Subject::class, 'doc_id');
    }
}
