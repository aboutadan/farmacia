<?php

namespace App\Http\Controllers\Patients;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClienteModel as Cliente;
use App\MedicalNoteModel as MedicalNote;

class CreateMedicalNotesController extends Controller 
{

    public function __construct() {
    	$this->middleware('auth'); 
    }


    public function index($id) {

    	// Get user name.
    	$patient = Cliente::select('id', 'nombre', 'apellido', 'created_at', 'updated_at', 'alertas')->find($id); 

        $checkDateUpdated = $this->checkDateUpdated($id);

        // This will force the user to update the profile. 
        // This will help to ensure all profiles adapt to the new changes.
        if($checkDateUpdated === false ) {
            $message = array(
                'type' => 'warning', 
                'message' => 'Antes de poder ingresar al perfil y/o añadir alguna consulta, es necesario actualizar los datos del paciente. ¡Gracias!'
            );
            return redirect('patient/edit/'.$id)->with($message);
        } else null;

        if($patient->created_at)

    	return view('patients.medical_note.create')->with('patient', $patient);

    }

    public function checkDateUpdated($id) {

        $dates = Cliente::select('created_at', 'updated_at')->find($id);

        $created = $dates->created_at; 
        $updated = $dates->updated_at; 

        $beforeDate = '2017-09-31 00:00:00'; 

        if($created < $beforeDate && $updated < $beforeDate) {
            return false;
        } else true;
    }


    public function validation(Request $request, $id) {

    	$messages = [
    		'1_tratamiento.required' => 'Al menos un tratamientos es necesario para continuar.'

    	];

    	$rules = [
    		'idx' => 'required',
    		'1_tratamiento' => 'required|string',
    		'2_tratamiento' => 'nullable|string',
    		'3_tratamiento' => 'nullable|string',
    		'4_tratamiento' => 'nullable|string',
    		'5_tratamiento' => 'nullable|string',
    		'talla'	=> 'nullable|numeric',
    		'peso' 	=> 'nullable|numeric',
    		'imc'	=> 'nullable|numeric',
			'ta'	=> 'nullable|string',
			'fc'	=> 'nullable|numeric',
			'fr' 	=> 'nullable|numeric',
			'temp'	=> 'nullable|numeric',
			'glc' 	=> 'nullable|numeric',
			'revision' => 'nullable|date_format:d/m/Y|after:today'
    	];

    	$validation = Validator::make($request->input(), $rules, $messages);

    	$attrNames = [
        	'idx' => 'Impresión Diagnóstica',
    		'1_tratamiento' => 'Tratamiento 1',
    		'2_tratamiento' => 'Tratamiento 2',
    		'3_tratamiento' => 'Tratamiento 3',
    		'4_tratamiento' => 'Tratamiento 4',
    		'5_tratamiento' => 'Tratamiento 5',
    		'talla'	=> 'Talla',
    		'peso' 	=> 'Peso'
        ];

        $validation->setAttributeNames($attrNames);

        if($validation->fails()) return redirect()->back()->withErrors($validation)->withInput();

        // Date formate is fixed.
        if($request->revision !== null || $request->revision !== '') {
            $appointment = str_replace('/', '-', $request->revision);
            $date = date('Y-m-d', strtotime($appointment));
        } else $date = null;

        $insert = MedicalNote::create([
        	'status' => 1,
	        'cliente_id' => $id,
            'usuario' => 0,
	        'added_by' => Auth::id(),
	        'idx' => $request->idx,
	        '1_tratamiento' => ($request->input('1_tratamiento') ===  null ? '' : $request->input('1_tratamiento')), 
	        '2_tratamiento' => ($request->input('2_tratamiento') ===  null ? '' : $request->input('2_tratamiento')), 
	        '3_tratamiento' => ($request->input('3_tratamiento') ===  null ? '' : $request->input('3_tratamiento')), 
	        '4_tratamiento' => ($request->input('4_tratamiento') ===  null ? '' : $request->input('4_tratamiento')), 
	        '5_tratamiento' => ($request->input('5_tratamiento') ===  null ? '' : $request->input('5_tratamiento')), 
	        'talla' => $request->talla, 
	        'peso' => $request->peso, 
	        'imc' => $request->imc, 
	        'ta' => $request->ta === null ? '' : $request->ta,
	        'fc' => $request->fc,
	        'fr' => $request->fr,
	        'temp' => $request->temp,
	        'glc' => $request->glc,
	        'revision' => $date
        ]);

       	$save = $insert->save();

       	if($save): 
       		$success = [
       			'message' => 'Se logró agregar la consulta con éxito!'
       		];
       		return redirect('patient/details/'.$id)->with($success);
       	endif;

    }


}
