<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorModel extends Model
{
    // This sets the primary key.
	protected $primaryKey = 'id';

	// This defines the name of the table.
    protected $table = 'users';
	
	// This will set datetime format.
	protected $dateFormat = 'Y-m-d H:i:s'; 
	
	// This table already has the correct columns.
	// const CREATED_AT = 'fecha';
    // const UPDATED_AT = 'last_update';
}
