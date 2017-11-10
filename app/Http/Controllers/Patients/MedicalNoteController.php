<?php

namespace App\Http\Controllers\Patients;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClienteModel as Cliente;
use App\User as User;
use App\NoteCommentModel as Note;
use App\MedicalNoteModel as MedicalNote;

// This helps create the PDF for the user.
use Dompdf\Dompdf;
use Dompdf\Options;

class MedicalNoteController extends Controller
{

	public function __construct() {
		$this->middleware('auth');
	}
    
	public function index($id, $note_id) {

		$patient = Cliente::select('id', 'nombre', 'apellido', 'fecha_nacimiento', 'alertas')->find($id);

		// This will pull information regarding the medical note.
		$medicalNote = MedicalNote::find($note_id);

		if($medicalNote) {
			$doctor_id = $medicalNote->added_by;
			$note_id = $medicalNote->id;
		}

		// This will get the doctors information.
		$doctor = User::select('title', 'fname', 'lname')->find($doctor_id);

		// By default, users can only see the first 10 recent comments. If greater than that,
		// a 'view more' button will be shown at the bottom to retrieve the additional comments.
		$totalComments = Note::select('idReceta')->where('idReceta', $note_id)->get();

		// This gets the comments related to the medical note.
		$noteComments = Note::where('idReceta', $note_id)
							->orderBy('fecha', 'desc')
							->offset(0)
							->limit(8)
							->join('users', 'users.id', '=', 'notas_receta.user_id')
							->get();

		if($noteComments) $comments = $noteComments; 
		else $comments = null;

		$data = [
			'patient' 		=> $patient, 
			'note' 			=> $medicalNote, 
			'doctor'		=> $doctor, 
			'comments'		=> $comments, 
			'totalComments'	=> $totalComments->count()
		];

		return view('patients.medical_note.details', $data);

	}

	public function addComment(Request $request) {

		$messages = [
			'notas.required' => 'El campo \'Agregar Comentario\' es requerido. Intente nuevamente.'
		];

		$validator = Validator::make($request->input(), [
			'idReceta' => 'required|numeric',
			'notas' => 'required'
		], $messages);
		
		if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

		$insertComment = Note::create([
			'idReceta' 	=> $request->idReceta,
			'fecha' 	=> date('Y-m-d H:i:s'),
			'notas'		=> $request->notas,
			'type'		=> 1,
			'user_id'	=> Auth::id()
		]); 

		$insertComment->save();

		return redirect()->back()->with('message', '¡Se agregó comentario con éxito!');

	}

	public function getAdditionalComments(Request $request) {

		if($request->ajax()) {

			$validator = Validator::make($request->input(), [
				'id' 		=> 'required|numeric', 
				'batch'		=> 'required|numeric'
			]);

			if($validator->fails()):
				return 'Algo no salio correcto.';
			else:

				$batch = ($request->input('batch') - 1) * 8;

				$additionalComments = Note::where('idReceta', $request->input('id'))
									->orderBy('fecha', 'desc')
									->offset($batch)
									->limit(8)
									->get();

		 		$returnView = view('patients.medical_note.additionalComments', ['comments' => $additionalComments])->render();
				return response()->json($returnView);
			endif;

		} else abort(404);
	}

	public function updateMedicalNote(Request $request, $id) {

		$rules = [
			'id' => 'required|numeric', 
			'changeTo' => 'required'
		];

		$validation = Validator::make($request->input(), $rules);

		$message = [
			'type' => 'danger', 
			'message' => 'No se logró cancelar la receta médica, intente nueavmente. Si el error persiste, avise al administrador.'
		];

		if($validation->fails()) return redirect()->back()->with($message)->withErrors($validation);

		if($request->changeTo === 'cancel')	$changeTo = 0; 
		elseif($request->changeTo === 'reactivate') $changeTo = 1;
		else null;

		$update = MedicalNote::find($request->input('id'))->update(['status' => $changeTo]);

		if($request->changeTo === 'cancel'): 
			$note = 'cancelo la receta'; 
		elseif($request->changeTo === 'reactivate'): 
			$note = 'reactivo la receta';
		endif;

		$addComment = Note::create([
			'idReceta' 	=> $request->id,
			'fecha' => date('Y-m-d H:i:s'),
			'notas'		=> $note, 
			'type'		=> 2,
			'user_id'	=> Auth::id()
		]);

		if($update): 
			$success = ['message' => '¡Se logró cancelar la receta médica con éxito!'];
			return redirect('patient/details/'.$id.'?status=1')->with($success);
		else:
			return redirect()->back()->with($message);
		endif;
	}

	public function printNote($id, $note_id) {

		// This pulls the customers information to create the medical note.
		$note = MedicalNote::find($note_id);
		$patient = $note->getPatient()->select('nombre', 'apellido', 'fecha_nacimiento')->get();

		$data = [
			'patient' 	=> $patient[0],
			'note' 		=> $note
		];

		$name = $patient[0]->nombre.'_'.$patient[0]->apellido;

		$file_name = str_replace(' ', '_', $name);

		$html = view('patients.medical_note.print', $data)->render();

		$options = new Options;
		$options->set('isHtml5ParserEnabled', true);

		$pdf = new Dompdf();
		$pdf->loadHtml($html);
		$pdf->setPaper('letter', 'portrait');
		$pdf->render();
		$pdf->stream($file_name.'.pdf', ['Attachment' => false]);
	}
}
