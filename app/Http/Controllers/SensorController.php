<?php

namespace App\Http\Controllers;

use App\Sensor;
use App\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SensorController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('sensors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('sensors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {

        return view('sensors.show', compact('sensor'));

    }

    public function show_exam(Exam $exam, Sensor $sensor, $time = null)
    {

        return view('exams.sensors.show', compact('exam', 'sensor', 'time'));

    }

    public function livedata(Sensor $sensor)
    {
        $flatdata = [];
        $data = $sensor->last_1_hour();

        if ($data) {
            $it = (new \RecursiveArrayIterator($data));
            foreach($it as $v) {
                array_push($flatdata, [Carbon::createFromTimestamp($v['time'])->setTimeZone(config('app.timezone'))->toDateTimeString(), $v['value']]);
            }
            return $flatdata;
        }
    }

    public function fulldata(Exam $exam, Sensor $sensor)
    {
        $flatdata = [];
        $data = $sensor->fulldata($exam);

        if ($data) {
            $it = (new \RecursiveArrayIterator($data));
            foreach($it as $v) {
                array_push($flatdata, [Carbon::createFromTimestamp($v['time'])->setTimeZone(config('app.timezone'))->toDateTimeString(), $v['value']]);
            }
            return $flatdata;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
