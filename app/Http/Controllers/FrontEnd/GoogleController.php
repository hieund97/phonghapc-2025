<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function getGoogleSignInUrl()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                            ->redirect()->getTargetUrl()
            ;

            return response()->json([
                'url' => $url,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginCallback(Request $request)
    {
        try {
            $state = $request->input('state');

            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if (!$user) {
                $user = User::create(
                    [
                        'email'     => $googleUser->email,
                        'name'      => $googleUser->name,
                        'google_id' => $googleUser->id,
                        'password'  => bcrypt('12345678'),
                    ]
                );
                $user->assignRole('Customer');
            }

            if (Auth::attempt([
                'email'     => $user->email,
                'password'  => '12345678',
            ])) {
                session()->flash('login_successfull', 'success');

                return redirect()->route('fe.home');
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status'  => __('google sign in failed'),
                'error'   => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
