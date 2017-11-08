<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login
Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@login')->name('login');
Route::post('/login', 'Auth\LoginController@loginUser');

// Password Reset
Route::get('password/reset', 'Auth\ForgotPasswordController@showForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Logout 
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// User Admin Page
Route::prefix('users')->group(function() {
	
	// View all users
	Route::get('/', 'Auth\ViewUsersController@index');

	// Edit User
	Route::get('edit/{id}', 'Auth\ViewUsersController@editUser')->where('id', '[0-9]+');
	Route::post('edit/{id}', 'Auth\ViewUsersController@validation')->where('id', '[0-9]+');

	// Add user -- Need to create a new controller.
	Route::get('new', 'Auth\CreateUsersController@index');
	Route::post('new', 'Auth\CreateUsersController@validation');
});

// Search Views
Route::prefix('search')->group(function () {
	// Main Search Page
	Route::get('/', 'Patients\SearchContoller@search');

	// Search display
	Route::get('results', 'Patients\SearchContoller@results');

	// ?? --- need to fix this. 
	Route::post('results', 'Patients\SearchContoller@results');
});

// Patient Views
Route::prefix('patient')->group(function ()  {

	// Patient Details
	Route::get('details/{id}', 'Patients\ProfileController@index')->where('id', '[0-9]+');

	// Medical Notes
	Route::get('medical_note/{id}/{note_id}', 'Patients\MedicalNoteController@index')->where('id', '[0-9]+')->where('note_id', '[0-9]+');
	Route::post('medical_note/{id}/{note_id}', 'Patients\MedicalNoteController@addComment')->where('id', '[0-9]+')->where('note_id', '[0-9]+');

	// Download Medical Notes
	Route::get('print_medical_note/{id}/{note_id}', 'Patients\MedicalNoteController@printNote')->where('id', '[0-9]+')->where('note_id', '[0-9]+');
	
	// Create Medical Note
	Route::get('new_medical_note/{id}', 'Patients\CreateMedicalNotesController@index')->where('id', '[0-9]+');
	Route::post('new_medical_note/{id}', 'Patients\CreateMedicalNotesController@validation')->where('id', '[0-9]+');

	// Update Medical Note
	Route::post('medical_note/update/{id}', 'Patients\MedicalNoteController@updateMedicalNote')->where('id', '[0-9]+');

	// Edit Medical Note
	Route::get('edit_medical_note/{userId}/{id}', 'Patients\EditMedicalNotesController@editNote')->where('id', '[0-9]+')->where('userId', '[0-9]+');
	Route::post('edit_medical_note/{userId}/{id}', 'Patients\EditMedicalNotesController@validation')->where('id', '[0-9]+')->where('userId', '[0-9]+');

	// Get additional comments
	Route::get('medical_note/getAdditionalComments', 'Patients\MedicalNoteController@getAdditionalComments');
	Route::post('medical_note/getAdditionalComments', 'Patients\MedicalNoteController@getAdditionalComments');

	// New Account
	Route::get('new', 'Patients\CreatePatientController@index');
	Route::post('new/insert', 'Patients\CreatePatientController@validation');

	// Edit Profile
	Route::get('edit/{id}', 'Patients\EditProfilesController@index')->where('id', '[0-9]+');
	Route::post('edit/{id}', 'Patients\EditProfilesController@validation')->where('id', '[0-9]+');

	// Deactivating an account
	Route::prefix('deactivate')->group(function () {

		// Starts the deactivation process.
		Route::get('/{id}', 'Patients\DeactivateProfilesController@index')->where('id', '[0-9]+')->name('deactivate');
		
		// Warning provided when account hass previous medical note, user will need to 
		// associate them with another one before the can deactivate the account.
		Route::post('/{id}/search', 'Patients\DeactivateProfilesController@search')->where('id', '[0-9]+');
		
		// Associate medical notes to searched patient account and deactivate account.
		Route::post('/{id}/associate', 'Patients\DeactivateProfilesController@associate')->where('id', '[0-9]+')->name('asociate');
		
		// Confirm deactivation
		Route::post('/{id}/confirmed', 'Patients\DeactivateProfilesController@confirmed')->where('id', '[0-9]+');
	});

});

// Other
Route::get('updating', 'UpdatingDBController@index');
Route::get('updating/ta', 'UpdatingDBController@changeTa');

// Message (Fail or Sucess - optional)
Route::get('messages', 'Patients\MessagesController@index');
