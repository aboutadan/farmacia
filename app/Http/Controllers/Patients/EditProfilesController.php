<?php

namespace App\Http\Controllers\Patients;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClienteModel as Cliente;

class EditProfilesController extends Controller
{
    
    public function __construct() {
    	$this->middleware('auth');
    }

	public function index($id) {

		$details = Cliente::find($id);

        // If the user's profile is maked as unactive, 
        // it will through a 404 error.
        if($details->status === 0) return abort(404);

		return view('patients.profile.edit', ['details' => $details]);

    }


    public function validation(Request $request, $id) {
    	
    	// Regex is to allow letters and spaces only.
        $rules = [
            'nombre'    => 'required|regex:/^[\pL\s]+$/u',
            'apellido'  => 'required|regex:/^[\pL\s]+$/u', 
            'dob'       => 'required|date_format:d/m/Y|before:'.date('d/m/Y'),
            'sexo'      => 'required|in:Masculino,Femenino',
            'telefono1' => 'nullable|numeric',
            'telefono2' => 'nullable|numeric',
            'email'     => 'nullable|email',
            'notas'     => 'nullable|string', 
            'alertas'   => 'nullable|string|max:100'
        ];
        
        $messages = [
            'regex' => 'El campo \':attribute\' sólo puede contener letras y espacios.'
        ];

        $validator = Validator::make($request->input(), $rules, $messages);

        // This help provide more accurante names so the user can identify which 
        // field needs to be fixed.
        $niceNames = [
        	'nombre'	=> 'Nombre', 
        	'apellido'	=> 'Apellido', 
        	'sexo'		=> 'Sexo',
            'telefono1' => 'No. Fijo', 
            'telefono2' => 'No. Móvil', 
            'dob'       => 'Fecha de Nacimiento',
            'email'     => 'Correo Electrónico', 
            'notas'		=> 'Notas', 
            'alertas'	=> 'Alertas'
        ];

        $validator->setAttributeNames($niceNames); 
        
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        // This is where fields will be updated if any changes were made.


        // Sex field is turned into an interger.
        if($request->sexo === 'Masculino') $sexo = 1;
        elseif ($request->sexo === 'Femenino') $sexo = 2; 
        else null;

        // Date formate is fixed.
        $inputDob = str_replace('/', '-', $request->dob);
        $dob = date('Y-m-d', strtotime($inputDob));

        $fields = [
        	'nombre' 	=> $request->nombre,
        	'apellido'	=> $request->apellido,
        	'fecha_nacimiento' => $dob,
        	'sexo'		=> $sexo, 
        	'telefono1'	=> $request->telefono1 === null ? '' : $request->telefono1, 
        	'telefono2'	=> $request->telefono2 === null ? '' : $request->telefono2,
        	'email'		=> $request->email === null ? '' : $request->email, 
        	'notas'		=> $request->notas === null ? '' : $request->notas,
        	'alertas'	=> $request->alertas === null ? '' : $request->alertas
        ];

        $update = Cliente::find($id)->update($fields);

        // In case update fails, user will be redirected back with error comments.
        if(!$update):
        	$updateErrorMessage = [
	        	'type' => 'danger', 
	        	'message'	=> '¡Uh-oh, algo salio mal! Intenta nuevamente. Si el error persiste, avisar al administrador.'
	        ];
        	return redirect()->back()->with($updateErrorMessage)->withInput();
        else:
            $success = [
                'type' => 'success', 
                'message' => '¡Se actualizo el perfil con éxito!'
            ];
        	return redirect('patient/details/'.$id.'?status=1')->with($success);
        endif;
    }
}
