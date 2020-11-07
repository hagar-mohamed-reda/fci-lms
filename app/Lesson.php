<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'name', 'date','sbj_id','youtube_link', 'pdf_file', 'pptx_file','doc_id'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'sbj_id');
    }

    public function assignments(){
        return $this->hasMany(Assignment::class, 'lesson_id');
    }
}
