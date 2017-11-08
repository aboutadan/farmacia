<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User as Users;

class ViewUsersController extends Controller
{

	public function __construct() {

		$this->middleware('auth');
	}

	public function index() {

		// Check if the user can access this page.
		if(!Auth::user()->isAdmin()) return abort(404);

		$users = Users::all();

		// Admin can see the list of all the users.
		return view('admin.viewUsers', ['users' =>  $users]);

	}

	public function editUser($id)  {

		if(!Auth::user()->isAdmin()) return abort(404);

		// This retrieves the user data.
		$user = Users::find($id);

		return view('admin.editUser', ['user' => $user]);

	}

	public function validation(Request $request, $id) {

		if(!Auth::user()->isAdmin()) return abort(404);

		$messages = [
			'fname.regex' => 'El campo \':attribute\' solo permite letras y espacios.',
			'lname.regex' => 'El campo \':attribute\' solo permite letras y espacios.',
			'password.regex' => 'La contraseña debe tener al menos 1 número.'
		];

		$rules = [
			'title' => 'required|in:Sr.,Srita.,Sra.,Dr.,Dra.', 
			'fname' => 'required|regex:/^[\pL\s]+$/u',
			'lname' => 'required|regex:/^[\pL\s]+$/u',
			'email' => 'required|email', 
			'password' => 'nullable|string|alpha_num|min:6|max:30|regex:/^(?:(?=.*\d)(?=.*[a-zA-Z]).*)$/|confirmed',
			'password_confirmation' => 'nullable|string'
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

		$fields = array(
			'title' => $request->title, 
			'fname' => $request->fname, 
			'lname' => $request->lname, 
			'email' => $request->email
		);

		// This is just in case the password was changed.
		if($request->password != null) $fields['password'] = Hash::make($request->password);

		$update = Users::find($id)->update($fields);

		if(!$update):
        	$error = [
	        	'type' => 'danger', 
	        	'message'	=> '¡Uh-oh, algo salio mal! Intenta nuevamente. Si el error persiste, avisar al administrador.'
	        ];
        	return redirect()->back()->with($error)->withInput();
        else:
            $success = [
                'type' => 'success', 
                'message' => '¡Se actualizo el perfil del usuario con exito con éxito!'
            ];
        	return redirect('users')->with($success);
        endif;
	}

}
