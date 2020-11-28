<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = "lms_departments";

    protected $fillable = [
        'name', 'level_id', 'notes'
    ];

    public function level() {
        return $this->belongsTo("App\Level");
    }
}
