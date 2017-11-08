<?php

namespace App\Http\Controllers\Patients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\ClienteModel as Cliente;

class ProfileController extends Controller {
    
    public function __construct() {
    	$this->middleware('auth');
    }

    public function index(Request $request, $id) {
		
		// This will set status to 1 if $_GET is not set.
    	if(!isset($_GET['status'])) return redirect('/patient/details/'.$id.'?status=1');

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

    	// This pulls the patient details
		$details = Cliente::find($id);

        // User will be shown a 404 error if user's not found or if the 
        // profile is maked as unactive.
		if(!$details || $details->status === 0) return abort(404);

		$recetas = Cliente::find($id)
						->medicalNotes()
						->select('id', 'idx', 'created_at', 'revision')
						->where('status', $_GET['status'])
						->orderBy('created_at', 'desc')
						->orderBy('id', 'desc')
						->paginate(10);

		if($recetas->count() === 0) $recetas = null;

		$status = $request->input('status');

		$data = [
			'patient' 	=> $details,
			'recetas'	=> $recetas,
			'status' 	=> $status
		];

    	return view('patients.profile.profile', $data);

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


}
