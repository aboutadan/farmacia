<?php

namespace App\Http\Controllers\Patients;

use Auth;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClienteModel as Cliente;
use App\MedicalNoteModel as MedicalNote;

class SearchContoller extends Controller {
	
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function search() {

		// This will help user see the medical notes created in that day.
		$from = date('Y-m-d').' 00:00:00';
		$to = date('Y-m-d').' 23:59:59';

		$notes = MedicalNote::select('cliente_id', 'idx')
			->whereBetween('created_at',[$from, $to])
			->where('added_by', Auth::id())
			->get();
	
		$patientInfo = [];
		foreach($notes as $note) {
			$patient = Cliente::select('nombre', 'apellido')->find($note->cliente_id);
			array_push($patientInfo, $patient);
		}

		// This is the main page for the search page.

		$data = array(
			'search' 		=> '',
			'searchby' 		=> 'Nombre', 
			'notes'			=> $notes, 
			'patientInfo' 	=> $patientInfo
		);
		
		return view('patients.search.form', $data);
		
	}
	
	public function results(Request $request) {

		$rules = [
			'buscar' => 'required|string', 
			'por' => 'required|in:Nombre,Apellido,Correo Electrónico,No. de Teléfono'
		];

		$this->validate($request, $rules);

		$value = $request->buscar;
		
		// For now, we're only pullling any profile where the status is active.

		if($request->por === 'No. de Teléfono'):
			$cliente = Cliente::select('id', 'status', 'nombre', 'apellido', 'created_at', 'edad', 'tipo_edad', 'fecha_nacimiento')
										->where('telefono1', 'LIKE', '%'.$value.'%')
										->orWhere('telefono2', 'LIKE', '%'.$value.'%')
										->where('status', 1)
										->paginate(15);
		else:
			switch($request->por) {
				case 'Nombre':
				case 'Apellido': 
					$searchby = strtolower($request->por);
					break; 
				case 'Correo Electrónico': 
					$searchby = 'email';
					break;
			}

			$cliente = Cliente::select('id', 'status', 'nombre', 'apellido', 'created_at', 'edad', 'fecha_nacimiento')
										->where($searchby, 'LIKE', '%'.$value.'%')
										->where('status', 1)
										->paginate(15);	
		endif;

		// User will be redirected to search page if more than 100 results are found.
		if($cliente->total() > 150 ) {
			return redirect('search')
					->back()
					->withErrors(['error' => 'Se encontraron mas de 150 resultados. Intente nuevamente.'])
					->withInput();
		}

		// User will be redirected to search page if no results are found.
		if($cliente->total() === 0) {
			return redirect('search')
				->withErrors(['error' => 'No se han encontrado resultados.'])
				->withInput();
		}

		// This will help populate the form.
		$data = [
			'cliente' 	=> $cliente,
			'search'	=> $value,
			'searchby'	=> $request->por
		];

		return view('patients.search.form', $data);
		
	}

}
