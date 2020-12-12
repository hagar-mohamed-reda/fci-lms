<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];
    protected $table = "lms_lessons";

    protected $fillable = [
        'name', 'date','sbj_id','youtube_link', 'pdf_file', 'mp4_file','pptx_file','doc_id'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'sbj_id');
    }

    public function assignments(){
        return $this->hasMany(Assignment::class, 'lesson_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doc_id');
    }
}
