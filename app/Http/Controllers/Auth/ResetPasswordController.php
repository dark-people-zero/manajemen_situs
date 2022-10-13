<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm($token)
    {
        return view('auth.passwords.reset');
    }

    public function reset(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);

        $validator->after(function ($validator) use($user, $request) {
            if (!Hash::check($request->oldpassword, $user->password) ) {
                $validator->errors()->add(
                    'oldpassword', 'The old password you entered is wrong'
                );
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user->password = Hash::make($request->newpassword);

        $user->save();


        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('info', 'Please Login again.');
    }
}
