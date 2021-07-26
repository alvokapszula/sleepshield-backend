<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamType extends Model
{

    protected $guarded = ['id'];

    public function exams()
    {
        return $this->belongsToMany(Exam::class)
            ->withTimestamps();
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class)
            ->withTimestamps();
    }

    public function shields()
    {
        return $this->belongsToMany(Shield::class)
            ->withTimestamps();
    }

    // TODO: examtype
    // public function shields()
    // {
    //     return $this->belongsToMany(Shield::class);
    // }
    //
    // public function patients()
    // {
    //     return $this->belongsToMany(Shield::class);
    // }
}
