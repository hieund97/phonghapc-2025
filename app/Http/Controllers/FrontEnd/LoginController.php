<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\LoginCustomer;
use App\Http\Requests\ProfileUpdate;
use App\Http\Requests\RegisterCustomerStore;
use App\Models\Province;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show form to login and register.
     */
    public function index()
    {
        return view('front_end.auth.login');
    }

    /**
     * Login for customers.
     */
    public function login(LoginCustomer $request)
    {
        $data  = $request->validated();
        $login = [
            'email'    => $data['email_log'],
            'password' => $data['password_log'],
        ];

        if (Auth::attempt($login)) {
            session()->flash('login_successfull', 'success');

            return response()->json(['message' => 'success'], 200);
        }
        session()->flash('login_failed', 'fail');

        return response()->json(['message' => 'fail'], 400);
    }

    /**
     * Register for customers.
     */
    public function register(RegisterCustomerStore $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'mobile'   => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
        $user->assignRole('Customers');
        session()->flash('register_successful', 'success');

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Logout for customers.
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('fe.home');
    }

    /**
     * Detail profile of customer.
     */
    public function profile()
    {
        $aryProvince = Province::all();

        return view('front_end.auth.detail', compact('aryProvince'));
    }

    /**
     * Update profile of customer.
     */
    public function updateProfile(ProfileUpdate $request)
    {
        $validated = $request->validated();
        $data      = [
            'name'        => $validated['name'],
            'mobile'      => $validated['mobile'],
            'sex'         => $validated['sex'],
            'province'    => $validated['province'],
            'address'     => $validated['address'],
            'description' => $validated['description'],
        ];
        $user      = Auth::user();
        if ($user->update($data)) {
            session()->flash('profile_updated', 'success');

            return redirect()->route('fe.profile')->with(['tab' => 'profile_update']);
        }

        session()->flash('profile_not_updated', 'fail');

        return redirect()->route('fe.profile')->with(['tab' => 'profile_update']);
    }

    /**
     * Change password for customer
     */
    public function changePassword(ChangePassword $request)
    {
        $validated = $request->validated();
        $data      = [
            'password' => Hash::make($validated['new_password']),
        ];
        $user      = Auth::user();

        if ($user->update($data)) {
            session()->flash('password_updated', 'success');

            return redirect()->route('fe.profile')->with(['tab' => 'change_password']);
        }

        session()->flash('password_not_updated', 'fail');

        return redirect()->route('fe.profile')->with(['tab' => 'change_password']);
    }
}
