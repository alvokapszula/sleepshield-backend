<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Shield extends Model
{

    protected $guarded = ['id'];
    protected $appends = ['running_exam', 'exam_count', 'exam_types_as_string'];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function exam_types()
    {
        return $this->belongsToMany(ExamType::class);
    }

    public function is_occupied()
    {
        if (isset($this->running_exam->id)) {
            return true;
        }

        return false;

    }

    public function getRunningExamAttribute()
    {
        return $this->exams->where('is_running', true)->first();
    }

    public function getExamCountAttribute()
    {
        return $this->exams->count();
    }

    public function getExamTypesAsStringAttribute()
    {
        $temp = "";
        foreach ($this->exam_types as $exam_type) {
            $temp .= $exam_type->name ." ";
        }
        return $temp;
    }

}
