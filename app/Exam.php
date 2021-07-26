<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Exam extends Model
{

    protected $guarded = ['id'];
    protected $appends = ['is_running', 'havent_started', 'exam_types_as_string'];
    protected $dates = [
        'created_at',
        'updated_at',
        'begin',
		'end'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function shield()
    {
        return $this->belongsTo(Shield::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam_types()
    {
        return $this->belongsToMany(ExamType::class);
    }

    public function getIsRunningAttribute()
    {
        if ((isset($this->begin) && $this->begin < now()) && ($this->end > now() || $this->end === null)) {
            return true;
        } else {
            return false;
        }
    }

    public function getPercentFromTime($time)
    {
        $begin = isset($this->begin) ? $this->begin->timestamp : now()->timestamp;
        $end = isset($this->end) ? $this->end->timestamp : now()->timestamp;

        $full = $end - $begin;
        $percent = $time - $begin;
        return $percent / $full * 100;

    }

    public function getHaventStartedAttribute()
    {
        if (!isset($this->begin) || ($this->begin > now() && ($this->end > now() || !isset($this->end)))) {
            return true;
        } else {
            return false;
        }
    }

    public function getExamTypesAsStringAttribute()
    {
        $temp = "";
        foreach ($this->exam_types as $exam_type) {
            $temp .= $exam_type->name ." ";
        }
        return $temp;
    }

    public function alarms() {
        $begin = isset($this->begin) ? $this->begin->setTimeZone('UTC')->toDateTimeString() : now()->setTimeZone('UTC')->toDateTimeString();
        $end = isset($this->end) ? $this->end->setTimeZone('UTC')->toDateTimeString() : now()->setTimeZone('UTC')->toDateTimeString();

        $sensors = $this->shield->sensors->where('normlow', '<>', 0);

        $reta = "{}";

        foreach ($sensors as $sensor) {

            $q = 'SELECT value, sensor FROM '.config('laravelinfluxapi.serie').' WHERE sensor = \''.$sensor->uid.'\'
                AND shield = \''.$this->shield->uid.'\' AND time > \''.$begin.'\' AND time < \''.$end.'\'';

            $temp = \InfluxApi::query($q, ['epoch' => 's'])->getPoints();

            try {
                $json = json_encode($temp);
                // $ret = substr($json, 1, strlen($json)-2);
                $reta = json_encode(array_merge(json_decode($json, true),json_decode($reta, true)));

                // $alarms = json_decode($ret, true);
            } catch (\Exception $e) {
                // no data
                continue;
            }
        }
        $r = json_decode($reta);
        // dd($r);
         // asort($r);
        usort($r, function($a, $b) {
                return $a->time - $b->time;
        });

        return $r;

    }


}
