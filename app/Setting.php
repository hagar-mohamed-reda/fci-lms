<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "lms_settings";

    protected $fillable = [
        'name',	'value', 'id'
    ];
}
