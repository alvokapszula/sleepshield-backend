<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shield;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shields = Shield::all();
        return view('home', compact('shields'));
    }
}
