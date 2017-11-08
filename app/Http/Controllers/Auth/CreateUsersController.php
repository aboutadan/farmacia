<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User as Users;

class CreateUsersController extends Controller
{

    public function __construct() {
    	$this->middleware('auth');

    }

    public function index() {

    	if(!Auth::user()->isAdmin()) return abort(404);
    	return view('admin/createUser');

    }

    public function validation(Request $request) {

    	// If user is not admin, they will be shown the 404 error page.
		if(!Auth::user()->isAdmin()) return abort(404);

		// Start of validation.
		$messages = [
			'fname.regex' => 'El campo \':attribute\' solo permite letras y espacios.',
			'lname.regex' => 'El campo \':attribute\' solo permite letras y espacios.',
			'password.regex' => 'La contraseña debe tener al menos 1 número.'
		];

		$rules = [
			'title' => 'required|in:Sr.,Srita.,Sra.,Dr.,Dra.', 
			'fname' => 'required|regex:/^[\pL\s]+$/u',
			'lname' => 'required|regex:/^[\pL\s]+$/u',
			'email' => 'required|email|unique:users,email', 
			'password' => 'required|string|alpha_num|min:6|max:30|regex:/^(?:(?=.*\d)(?=.*[a-zA-Z]).*)$/|confirmed',
			'password_confirmation' => 'string'
		];
		
		$validate = Validator::make($request->input(), $rules, $messages);

		$attrNames = [
			'title' => 'Título', 
			'fname' => 'Nombre',
			'lname' => 'Apellido',
			'email' => 'Correo Electrónico', 
			'password' => 'Contraseña', 
			'password_confirmation' => 'Confirmar Contraseña'
		];

		$validate->setAttributeNames($attrNames); 

		if($validate->fails()) return redirect()->back()->withErrors($validate)->withInput(); 

		// If user passes validation, then they will be added to the database.
		$password = Hash::make($request->password);

		$insert = Users::create([
			'title' => $request->title, 
			'fname' => $request->fname, 
			'lname' => $request->lname, 
			'email' => $request->email, 
			'password' => $password, 
			'is_admin' => 0, 
			'status' => 1
		]);

		// Redirects and messages if user was added or not.
		if(!$insert):
        	$error = [
	        	'type' => 'danger', 
	        	'message'	=> '¡Uh-oh, algo salio mal! Intenta nuevamente. Si el error persiste, avisar al administrador.'
	        ];
        	
        	return redirect()->back()->with($error)->withInput();
        else:
            $success = [
                'type' => 'success', 
                'message' => '¡Se logró añadir el perfil del usuario con éxito!'
            ];

        	return redirect('users')->with($success);
        endif;
    }

}
