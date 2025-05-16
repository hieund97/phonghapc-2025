<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function getFacebookSignInUrl()
    {
        try {
            $url = Socialite::driver('facebook')->stateless()
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
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::where('facebook_id', $facebookUser->id)->first();
            if (!$user) {
                $user = User::create(
                    [
                        'email'       => $facebookUser->email ?? $facebookUser->id . '@facebook.com',
                        'name'        => $facebookUser->name,
                        'facebook_id' => $facebookUser->id,
                        'password'    => bcrypt('12345678'),
                    ]
                );
                $user->assignRole('Customers');
            }

            if (Auth::attempt([
                'email'    => $user->email,
                'password' => '12345678',
            ])) {
                session()->flash('login_successfull', 'success');

                return redirect()->route('fe.home');
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status'  => __('Facebook sign in failed'),
                'error'   => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
