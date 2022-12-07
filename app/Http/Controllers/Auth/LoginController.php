<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $role = $user->role;
            if ($role->role_id != 4) {
                $active = $user->aksesMenu->where('status', true)->first();
                if ($active) {
                    $url = '/';
                    if (strtolower($active->name) == 'user') $url = '/user';
                    if (strtolower($active->name) == 'site') $url = '/';
                    if (strtolower($active->name) == 'site data') $url = '/data-situs';
                    $request->session()->regenerate();
                    return redirect($url);
                }else{
                    // return redirect('/permision');
                    return back()->withErrors([
                        "error" => "Your account has not got any menu access, please contact SMB Spv to get menu access"
                    ]);
                }
            }else{
                $request->session()->regenerate();
                return redirect('/user');
            }
        }

        return back()->withErrors([
            "error" => "The provided credentials do not match our records."
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
