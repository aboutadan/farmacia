<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function index() {
    	return redirect('/login');
    }
	
	public function login() {

        if(Auth::check()) {
            $user = Auth::user()->title.' '.Auth::user()->fname.' '.Auth::user()->lname;
            return redirect('search')->with('message', '¡Bienvenido nuevamente '.$user.'!');
        }

		return view('login.index');
	}
	
}
