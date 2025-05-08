<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePassword;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function password()
    {
        return view('profile.password');
    }

    public function updatePassword(UpdatePassword $request)
    {
        $data = $request->validated();

        Auth::logoutOtherDevices($data['password']);

        return redirect()->route('dashboard')->with('success', __('Change password success'));
    }
}
