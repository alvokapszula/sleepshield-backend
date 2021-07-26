<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
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
        return view('patients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
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
            'gender' => 'required|in:1,2',
            'lastname' => 'required',
            'firstname' => 'required',
            'birthdate' => 'required|date',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1000',
            'comments' => 'nullable',
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('public/patient_images');
            $path = str_replace('public', 'storage', $path);
        } else {
            $path = "storage/patient_images/placeholder.png";
        }

        try {
            $patient = Patient::create(array_merge(request(['firstname','lastname','gender','birthdate', 'weight','height', 'comments', 'image']),['image' => $path]));
            $patient->exam_types()->attach($request->exam_types);
      	} catch (Exception $e) {
      		  return redirect('/patients')->withErrors(__('messages.patients.error-create',['error' => $e]));
      	}

        return redirect('/patients')->withSuccess(__('messages.patients.success-create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $this->validate(request(), [
            'gender' => 'required|in:1,2',
            'lastname' => 'required',
            'firstname' => 'required',
            'birthdate' => 'required|date',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1000',
            'comments' => 'nullable',
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('public/patient_images');
            $path = str_replace('public', 'storage', $path);
        } else {
            $path = "storage/patient_images/placeholder.png";
        }

        try {
            $patient->update(array_merge(request(['firstname','lastname','gender','birthdate', 'weight','height', 'comments', 'image']),['image' => $path]));
            $patient->exam_types()->sync($request->exam_types);
        } catch (Exception $e) {
  		    return redirect('/patients/'.$patient->id.'/edit')->withErrors(__('messages.patients.error-update',['error' => $e]));
        }

        return redirect('/patients/'.$patient->id)->withSuccess(__('messages.patients.success-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        try {
    		$patient->delete();
    	} catch (Exception $e) {
    		return redirect('/patients')->withErrors(__('messages.patients.error-delete',['error' => $e]));
    	}

		return redirect('/patients')->withSuccess(__('messages.patients.success-delete'));
	}
}
