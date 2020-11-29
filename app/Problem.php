<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = "problems";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'notes', 'status', 'type', 'user_id', 'comment', 'code'
        //- status ['success', 'warning', 'error']
        //- type ['doctor', 'student']
    ];


    public function user() {
        return $this->belongsTo("App\User",'user_id');
    }
}
