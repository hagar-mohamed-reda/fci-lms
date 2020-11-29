<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;

    protected $table = "levels";

    protected $fillable = [
        'name'
    ];

    public function students() {
        return $this->hasMany("App\User", "level_id");
    }

    public function departments() {
        return $this->hasMany("App\Department", "level_id");
    }
}
