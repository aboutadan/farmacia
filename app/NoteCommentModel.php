<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteCommentModel extends Model
{
    // This sets the primary key.
	protected $primaryKey = 'id';

	protected $guarded = [];

	// This defines the name of the table.
    protected $table = 'notas_receta';
	
	// This will set datetime format.
	protected $dateFormat = 'Y-m-d H:i:s'; 

	public $timestamps = false;
	
	// This will define the created and updated date.
	const CREATED_AT = 'fecha';
    // const UPDATED_AT = 'last_update';

}
