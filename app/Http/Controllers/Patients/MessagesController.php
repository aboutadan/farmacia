<?php

namespace App\Http\Controllers\Patients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{

    public function __construct() {
    	$this->middleware('auth');
    }

    public function index() {

    	// This should only output the message if the user's account
    	// was cancelled successfully.

    	if(!session('passMessage')) {
    		$message = [
    			'type' 		=> 'danger', 
    			'message' 	=> '¡Uh-oh! Algo salio mal, intenta nuevamente. Si el error persiste, favor de avisar al administrador.'
    		];
    		return redirect('search')->with($message);
    	}

    	return view ('messages.default', session('passMessage'));

    }

}
