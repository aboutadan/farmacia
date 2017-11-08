<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'title', 'fname', 'lname', 'email', 'is_admin', 'password', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {

        $user = (int) $this->is_admin; 

        if($user === 1) return true;
        else return false;
    }

    // Sends password reset email to user.
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }

}
