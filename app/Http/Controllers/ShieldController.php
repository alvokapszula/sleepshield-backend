<?php

namespace App\Http\Controllers;

use App\Shield;
use App\Sensor;
use Illuminate\Http\Request;

class ShieldController extends Controller
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
        return view('shields.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shields.create');
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
            'name' => 'required',
            'uid' => 'required',
        ]);

        try {
            $shield = Shield::create(request(['name','uid']));
            $shield->exam_types()->attach($request->exam_types);

            $sensors = [
                [ "Pulzus", "pulse", 55, 70, "/perc"],
                [ "Légzésszám", "resp", 20, 40, "/perc"],
                [ "Testhőmérséklet", "temp", 36, 37.3, "°C"],
                [ "Izom rángás", "muscle", 0, 0, "/perc"],
                [ "Oxigén szint", "spo2", 96, 100, "%"],
                [ "Pozíció", "bodypos", 0, 0, null],
                [ "Horkolás", "snore", 0, 0, "/perc"],
                [ "Galvanic?", "galvanic", 0, 100, "NaN"],
            ];

            $descriptions = [
                $sensors[0][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[1][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[2][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[3][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[4][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[5][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[6][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
                $sensors[7][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            ];

            for ($i=0;$i<8;$i++) {
                $sensor = Sensor::create([
                    'name'     => $sensors[$i][0],
                    'uid'     => $sensors[$i][1],
                    'shield_id' => $shield->id,
                    'normlow'   => $sensors[$i][2],
                    'normhigh'   => $sensors[$i][3],
                    'unit'  => $sensors[$i][4],
                    'description' => $descriptions[$i],
                ]);
            }

        } catch (Exception $e) {
            return redirect('/shields')->withErrors(__('messages.shields.error-create',['error' => $e]));
        }

        // TODO attach seonsors
        return redirect('/shields')->withSuccess(__('messages.shields.success-create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shield  $shield
     * @return \Illuminate\Http\Response
     */
    public function show(Shield $shield)
    {
        return view('shields.show', compact('shield'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shield  $shield
     * @return \Illuminate\Http\Response
     */
    public function edit(Shield $shield)
    {
        return view('shields.edit', compact('shield'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shield  $shield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shield $shield)
    {
        $this->validate(request(), [
            'name' => 'required',
            'uid' => 'required',
        ]);

        try {
            $shield->update(request(['name','uid']));
            $shield->exam_types()->sync($request->exam_types);
      	} catch (Exception $e) {
      		return redirect('/shields/'.$shield->id.'/edit')->withErrors(__('messages.shields.error-update',['error' => $e]));
      	}

        return redirect('/shields/'.$shield->id)->withSuccess(__('messages.shields.success-update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shield  $shield
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shield $shield)
    {
        try {
    		$shield->delete();
    	} catch (Exception $e) {
    		return redirect('/shields')->withErrors(__('messages.shields.error-delete',['error' => $e]));
    	}

		return redirect('/shields')->withSuccess(__('messages.shields.success-delete'));
    }
}
