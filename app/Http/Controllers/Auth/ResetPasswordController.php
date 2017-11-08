<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;

use App\PasswordReset as PasswordReset;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function __construct() {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token) {

        if(!isset($token)) {
            return abort(404);
        }

        // Form to reset password.
        return view('auth.password.reset-password', [
            'token' => $token
        ]);
    }

    // Sets the rules to validate forms.
    public function rules() {
        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|string|alpha_num|min:6|max:30|regex:/^(?:(?=.*\d)(?=.*[a-zA-Z]).*)$/|confirmed',
            'password_confirmation' => 'nullable|string'
        ];

        return $rules;
    }

}
