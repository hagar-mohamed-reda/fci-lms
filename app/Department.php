<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = "departments";

    protected $fillable = [
        'name', 'level_id', 'notes'
    ];

    public function level() {
        return $this->belongsTo("App\Level");
    }

    public function students() {
        return $this->hasMany("App\Student", "department_id");
    }
}
