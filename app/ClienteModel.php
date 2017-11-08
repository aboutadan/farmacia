<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{

	protected $primaryKey = 'id';

	// This defines the name of the table.
    protected $table = 'cliente';
	
	protected $guarded = [];
	
	// This will set datetime format.
	protected $dateFormat = 'Y-m-d H:i:s'; 
	
	// This will define the created and updated date.
	// const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';

	public function medicalNotes() {

		return $this->hasMany('App\MedicalNoteModel', 'cliente_id');

	}
	
	public function recentMedicalNote() {
		$this->medicalNotes()
			->select('fecha')
			->orderBy('fecha', 'desc')
			->last();
	}

}
