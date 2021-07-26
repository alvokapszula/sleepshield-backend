<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{

    protected $guarded = ['id'];
    protected $appends = ['running_exam'];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function exam_types()
    {
        return $this->belongsToMany(ExamType::class);
    }

    // TODO: examtype
    // public function exam_types()
    // {
    //     return $this->belongsToMany(ExamType::class);
    // }

    public function fullname()
    {
        return $this->firstname." ".$this->lastname;
    }

    public function getRunningExamAttribute()
    {
        return $this->exams->where('is_running', true)->first();
    }
}
