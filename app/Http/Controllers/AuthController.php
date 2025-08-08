<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return '/ph_admin';
    }
}
