<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function showForm() {
        // Shows form to reset password.
        return view('auth.password.reset-request');
    }

    public function broker() {
        return Password::broker('users');
    }

}
