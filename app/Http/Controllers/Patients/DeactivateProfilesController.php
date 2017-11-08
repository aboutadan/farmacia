<?php

namespace App\Http\Controllers\Patients;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalNoteModel as MedicalNote;
use App\ClienteModel as Cliente;

class DeactivateProfilesController extends Controller
{
    
	public function __construct() {
		$this->middleware('auth');
	}


	public function index($id) {

		$patient = Cliente::select('nombre', 'apellido')->find($id)->firstOrFail();

		// Before anthing, we confirm if there are any medical notes associated with the account.
		$medicalNotes = MedicalNote::select('cliente_id')->where('cliente_id', $id)->get();

		$data = [
			'patient' 	=> $patient,
			'find' 		=> ($medicalNotes->count() > 0 ? true : false),
			'count' 	=> ($medicalNotes->count() !== 0 ? $medicalNotes->count() : null)
		];

		return view('patients.profile.deactivate.main', $data);
	}



	public function search(Request $request, $id) {

		$validator = Validator::make($request->input(), ['profileId' => 'required|numeric']);

		$validator->setAttributeNames(['profileId' => 'No. de Perfil']);

		// This will let user know they have to enter an id to the new account, not the account 
		// they are trying to cancel.
		if($request->profileId === $id) {
			$error = [
				'type' => 'danger', 
				'message' => '¡Uh-oh! El número de perfil que ingresaste tiene que ser diferente.'
			];
			return redirect()->back()->with($error);
		}

		if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

		$findId = $request->input('profileId');
		$result = Cliente::select('id', 'nombre', 'apellido', 'fecha_nacimiento', 'telefono1', 'telefono2', 'email')->find($findId);

		return view('patients.profile.deactivate.searchResult', ['result' => $result]);
	}




	public function associate(Request $request, $id) {

		$validator = Validator::make($request->input(), ['profileId' => 'required|numeric']);

		$validator->setAttributeNames(['profileId' => 'No. de Perfil']);

		if($validator->fails()) return redirect()->route('deactivate', $id)->withErrors($validator)->withInput();

		// This is where we associate all previous medical notes with
		// the new profile indicated by user.

		$medicalNotes = MedicalNote::select('id')->where('cliente_id', $id)->get();
		
		if($medicalNotes) {
			foreach($medicalNotes as $note) {
				MedicalNote::find($note->id)->update(['cliente_id' => $request->profileId]);			
			}
		} else {
			$error = [
				'type' =>  'danger', 
				'message' => '¡Uh-oh! Algo salio mal, intenta nuevamente. Si el error persiste, avisa al administrador.'
			];
			return redirect()->route('deactivate', $id)->with($error); 
		}


		// If all goes well, we also need to change the status on current
		// profile to deactivate.

		$update = Cliente::find($id)->update(['status' => 0]);

		$patient = Cliente::select('nombre', 'apellido')->find($id);

		if($update):
			$success = [
				'type' 		=> 'success',
				'title'		=> '¡Desactivación Exitosa!',
				'message' 	=> 'Se logro desactivar el perfil de '.$patient->nombre.' '.$patient->apellido.' con exito.',
				'url'		=> asset('search'), 
				'redirect'  => true
			];
			return redirect('messages')->with('passMessage', $success); 
		else:
			$error = [
				'type' 		=> 'error',
				'title'		=> '¡Uh-oh, algo salio mal!',
				'message' 	=> 'No se logro desactivar el perfil de '.$patient->nombre.' '.$patient->apellido.', intenta nuevamente. Si el error persiste, avisar al administrador.',
				'url'		=> asset('patient/edit/'.$id), 
				'redirect'  => true
			];
			return redirect('messages')->with('passMessage', $error); 
		endif;	

		// If all good, user will be redirected to confirmed page.

	}




	public function confirmed(Request $request, $id)  {				

		$rules = [
			'type' => 'required|in:confirmed'
		];

		$validator = Validator::make($request->all(), $rules); 

		$error = [
			'type' 		=> 'danger', 
			'message' 	=> '¡Uh-oh, algo salio mal! Intenta nuevamente.'
		]; 

		if($validator->fails()) return redirect('patient/edit/'.$id)->with($error);

		// After user passes the validation, they will be redirected to the correct function
		// to either asociate the medical notes with the correct profile or to 
		// deactivate the account.

		$update = Cliente::find($id)->update([
			'status' => 0
		]); 

		$patient = Cliente::select('nombre', 'apellido')->find($id);

		if($update):
			$success = [
				'type' 		=> 'success',
				'title'		=> '¡Desactivación Exitosa!',
				'message' 	=> 'Se logro desactivar el perfil de '.$patient->nombre.' '.$patient->apellido.' con exito.',
				'url'		=> asset('search'), 
				'redirect'  => true
			];
			return redirect('messages')->with('passMessage', $success); 
		else:
			$error = [
				'type' 		=> 'error',
				'title'		=> '¡Uh-oh, algo salio mal!',
				'message' 	=> 'No se logro desactivar el perfil de '.$patient->nombre.' '.$patient->apellido.', intenta nuevamente. Si el error persiste, avisar al administrador.',
				'url'		=> asset('patient/edit/'.$id), 
				'redirect'  => true
			];
			return redirect('messages')->with('passMessage', $error); 
		endif;	

	}	

}
