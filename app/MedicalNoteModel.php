<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalNoteModel extends Model {
    
    // This sets the primary key.
	protected $primaryKey = 'id';

	// This defines the name of the table.
    protected $table = 'receta';
	
	// This will set datetime format.
	protected $dateFormat = 'Y-m-d H:i:s'; 
	
	protected $guarded = [];

	public function getPatient() {

		return $this->hasOne('App\ClienteModel', 'id', 'cliente_id');

	}

	public function getDoctor() {
		return $this->hasOne('App\User', 'id', 'added_by');
	}

}
