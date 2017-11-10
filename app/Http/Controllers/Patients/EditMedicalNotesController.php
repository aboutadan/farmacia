<?php

namespace App\Http\Controllers\Patients;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClienteModel as Cliente;
use App\MedicalNoteModel as MedicalNote;

use Validator;

class EditMedicalNotesController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function editNote($userId, $id) {
		
		// This is where users can edit the medical note. 
		// They should only be able to do it within the first hour of creating the note.

		$note = MedicalNote::find($id);
		$patient = $note->getPatient()->select('nombre', 'apellido')->get();

		$data = [
			'note' => $note,
			'patient' => $patient[0]
		];

		return view('patients.medical_note.edit', $data);

	}

	public function validation(Request $request, $userId, $id) {

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

    	$validation = Validator::make($request->all(), $rules, $messages);

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

        $update = MedicalNote::find($id)->update([
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
	        'revision' => $request->revision
        ]);

       	if($update): 
       		$success = [
       			'message' => 'Se logró actualizar la receta médica con éxito!'
       		];
       		return redirect('patient/details/'.$request->cliente_id)->with($success);
       	endif;


	}


}
