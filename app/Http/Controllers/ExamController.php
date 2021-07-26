<?php

namespace App\Http\Controllers;

use App\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
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
        return view('exams.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'patient_id' => 'required|exists:patients,id',
            'shield_id' => 'required|exists:shields,id',
            'user_id' => 'required|exists:users,id',
            'begin' => 'date|nullable',
            'end' => 'nullable|date',
            'comments' => 'nullable',
        ]);

          try
          {
            $exam = Exam::create(request(['patient_id','shield_id','user_id', 'begin', 'end','comments']));
            $exam->exam_types()->attach($request->exam_types );
      	  }
      	  catch (Exception $e)
      	  {
      		  return redirect('/exams')->withErrors(__('messages.exams.error-create',['error' => $e]));
      	  }
        return redirect('/exams/'.$exam->id)->withSuccess(__('messages.exams.success-create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        // dd(request()->end);
        $this->validate(request(), [
            'patient_id' => 'required|exists:patients,id',
            'shield_id' => 'required|exists:shields,id',
            'user_id' => 'required|exists:users,id',
            'begin' => 'nullable|date',
            'end' => 'nullable|date',
            'comments' => 'nullable',
        ]);
        // dd(request('begin'));

          try
          {
            $exam->update(request(['patient_id','shield_id','user_id','begin', 'end','comments']));
            $exam->exam_types()->sync($request->exam_types );
      	  }
      	  catch (Exception $e)
      	  {
      		  return redirect('/exams'.$exam->id.'/edit')->withErrors(__('messages.exams.error-update',['error' => $e]));
      	  }
        return redirect('/exams/'.$exam->id)->withSuccess(__('messages.exams.success-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        try
    		{
    			$exam->delete();
    		}
    		catch (Exception $e)
    		{
    		  return redirect('/exams/'.$exam->id.'/edit')->withErrors(__('messages.exams.error-delete',['error' => $e]));
    		}

		return redirect('/exams')->withSuccess(__('messages.exams.success-delete'));
    }

    public function start(Exam $exam)
    {

        if (isset($exam->begin)) {
            return redirect()->back()->withErrors(__('exam.messages.already-started'));
        }

        if (isset($exam->end)) {
            return redirect()->back()->withErrors(__('exam.messages.already-ended'));
        }

        if (isset($exam->shield->running_exam->id)) {
            return redirect()->back()->withErrors(__('exam.messages.shield-has-exam-running',['exam' => $exam->shield->running_exam->id]));
        }

        if (isset($exam->patient->running_exam->id)) {
            return redirect()->back()->withErrors(__('exam.messages.patient-has-exam-running',['exam' => $exam->patient->running_exam->id]));
        }

        try {
            $exam->begin = now();
            $exam->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(__('messages.exams.error-start',['error' => $e]));
        }

        return redirect()->back()->withSuccess(__('messages.exams.success-start'));
    }

    public function stop(Exam $exam)
    {

        if (!isset($exam->begin)) {
            return redirect()->back()->withErrors(__('exam.messages.havent-started'));
        }

        if (isset($exam->end)) {
            return redirect()->back()->withErrors(__('exam.messages.already-ended'));
        }

        try {
            $exam->end = now();
            $exam->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(__('messages.exams.error-stop',['error' => $e]));
        }

        return redirect()->back()->withSuccess(__('messages.exams.success-stop'));
    }

    public function alarms(Exam $exam)
    {
        return view('exams.alarms.show', compact('exam'));
    }

}
