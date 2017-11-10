<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
  
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/search';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginUser(Request $request) {

        // Before login attemp, we validate the input data.
        $rules = [
            'branch'    => 'required|in:Tierra Arbolada,Séptimo Sol',
            'email'     => 'required|email', 
            'password'  => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules); 

        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput($request->except('password'));
        
        // After validation, will attempt to login in user.
        $login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if($login) {
            // This creates a session variable with the branch the user selected during 
            // the login.
            Session::put('branch' , $request->branch);
            return redirect()->intended('/search');
        } else {
            return redirect()->back()->withErrors(['El usuario y contraseña no coinciden, intente nuevamente.'])->withInput($request->except('password'));
        }
    }

    public function logout() {
        
        Auth::logout(); 
        return redirect('/');
    }


}
