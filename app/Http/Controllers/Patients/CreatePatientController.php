<?php

namespace App\Http\Controllers\Patients;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\ClienteModel as Cliente;

class CreatePatientController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }

    public function index() {

        return view('patients.new_account.create');

    }



    public function validation(Request $request) {

        // Regex is to allow letters and spaces only.
        $rules = [
            'confirmed_insert' => 'numeric',
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
            'nombre'    => 'Nombre', 
            'apellido'  => 'Apellido', 
            'sexo'      => 'Sexo',
            'telefono1' => 'No. Fijo', 
            'telefono2' => 'No. Móvil', 
            'dob'       => 'Fecha de Nacimiento',
            'email'     => 'Correo Electrónico', 
            'notas'     => 'Notas', 
            'alertas'   => 'Alertas'
        ];

        $validator->setAttributeNames($niceNames); 
        
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $duplicates = $this->findDuplicates($request);

        // If duplicates are found, user will be displayed any matches for them to review.
        // This will also insert a input filed called 'confimed_insert', this will confirm the user has seen the
        // profile(s) and to create the new account.
        if($request->input('confirmed_insert') === null) {
            if($request->input('confirmed_insert') === 1) return null; 
            else {
                if($duplicates !== true) {
                    $data = [];

                    foreach($duplicates as $section => $profiles) {
                        $data[$section] = Cliente::select('id', 'nombre', 'apellido', 'fecha_nacimiento', 'sexo', 'edad', 'tipo_edad')
                                            ->find($profiles);
                    }

                    $data['insertDuplicates'] = true;
                    $data['type'] = 'warning';
                    $data['message'] = 'Se encontraron perfiles con los datos ingresados.  Revisar si la cuenta del paciente ya existe.';

                    return redirect()->back()->with($data)->withInput();
                }
            }
        }
        
        // Once inputs have been validated (and user has confirmed duplicates, if any, are not related, then
        // the new account will be created.
        if($request->input('sexo') === 'Masculino') $sexo = 1; 
        else $sexo = 0;

        // This is necesary, 'strtotime' doesn't work with forward slash to do converting.
        $inputDob = str_replace('/', '-', $request->dob);
        $dob = date('Y-m-d', strtotime($inputDob));

        $createProfile = Cliente::create([
            'nombre'    => $request->nombre,
            'apellido'  => $request->apellido,
            'fecha_nacimiento' => $dob,
            'edad'      => 0, 
            'tipo_edad' => 0,
            'sexo'      => $sexo,
            'telefono1' => ($request->telefono1 === null ? '' : $request->telefono1), 
            'telefono2' => ($request->telefono2 === null ? '' : $request->telefono2),
            'email'     => ($request->email === null ? '' : $request->email),
            'notas'     => ($request->notas === null ? '' : $request->notas),
            'alertas'   => ($request->alertas === null ? '' : $request->alertas), 
            'added_by'  => Auth::user()->id
        ]);

        $save = $createProfile->save();

        if(!$save):

            $message = [
                'type' => 'danger', 
                'message' => '¡Uh-oh! No se logro crear nuevo perfil, intenta nuevamente. Si el error continua favor de avisar al administrador.'
            ];

            return redirect()->back()->with($message)->withInput();
        else:
            
            $newId = $createProfile->id;

            return redirect('patient/details/'.$newId)->with('message', '¡Se creo la cuenta con exito!');
        endif;

    }



    public function findDuplicates($request) {

        // This function will check to see if any profiles already have the same name (first and last), phone numbers or email.
        // If any options are found

        $byName = Cliente::select('id')
            ->where('status', 1)
            ->where('nombre', $request->input('nombre'))
            ->where ('apellido', $request->input('apellido'))
            ->get();

        if($byName->count() > 0) {
            $duplicates['byName'] = array();
            foreach($byName as $profile) {
                array_push($duplicates['byName'], $profile->id);
            }
        }

        if($request->telefono1 !== null ) {

            $byPhone1 = Cliente::select('id')
                ->where('status', 1)
                ->where('telefono1', 'LIKE', $request->input('telefono1'))
                ->orWhere('telefono2', 'LIKE', $request->input('telefono1'))
                ->get();

            if($byPhone1->count() > 0) {
                $duplicates['byPhone1'] = array();
                foreach($byPhone1 as $profile) {
                    array_push($duplicates['byPhone1'], $profile->id);
                }
            }

        }

        if($request->telefono2 !== null ) {

            $byPhone2 = Cliente::select('id')
                ->where('status', 1)
                ->where('telefono1', 'LIKE', $request->input('telefono2'))
                ->orWhere('telefono2', 'LIKE', $request->input('telefono2'))
                ->get();
            
            if($byPhone2->count() > 0) {
                $duplicates['byPhone2'] = array();
                foreach($byPhone2 as $profile) {
                    array_push($duplicates['byPhone2'], $profile->id);
                }
            }

        }

        if($request->email !== null ) {

            $byEmail = Cliente::select('id')
                ->where('status', 1)
                ->where('email', 'LIKE', $request->input('email'))
                ->get();
            
            if($byEmail->count() > 0) {
                foreach($byEmail as $profile) {
                    $duplicates['email'] = array();
                    array_push($duplicates['email'], $profile->id);
                }
            }

        }

        if(!empty($duplicates)) return $duplicates; 
        else return true;

    }


}
