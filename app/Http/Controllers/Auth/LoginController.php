<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\log;

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
        $cookies = [];
        $cookiesReq = explode(";", $request->server("HTTP_COOKIE"));

        foreach ($cookiesReq as $val) {
            $x = explode("=", $val);
            $key = str_replace(" ", "", $x[0]);
            $cookies[$key] = $x[1];
        }

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $ip = $request->ip();
        $location = collect([
            "latitude" => $cookies["latitude"],
            "longitude" => $cookies["longitude"],
            "accuracy" => $cookies["accuracy"],
        ])->toJson();

        $dataLog = [
            'class' => "LoginController->login",
            'name_activity' => "Authentication",
            'data_ip' => $ip,
            'data_location' => json_encode($location),
            'keterangan' => "Mencoba login dengan username '".$request->username."'",
        ];

        log::create($dataLog);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $role = $user->role;
            if ($role->role_id != 1) {
                $active = $user->aksesMenu->where('status', true)->first();

                if ($active != null) {
                    $url = '/';
                    if (strtolower($active->name) == 'user') $url = '/user';
                    if (strtolower($active->name) == 'site') $url = '/';
                    if (strtolower($active->name) == 'site data') $url = '/data-situs';
                    $dataLog['data_user'] = $user->toJson();
                    $dataLog['keterangan'] = "Berhasil login dengan username '".$request->username."'";
                    log::create($dataLog);
                    $request->session()->regenerate();
                    return redirect($url);
                }else{

                    $dataLog['data_user'] = $user->toJson();
                    $dataLog['keterangan'] = "Mencoba login dengan username '".$request->username."'. Tetapi dikembalikan karena user tidak mempunyai akses ke manu manapun.";
                    log::create($dataLog);

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/login')->withErrors([
                        "error" => "Your account has not got any menu access, please contact SMB Spv to get menu access"
                    ]);
                }
            }else{
                $dataLog['data_user'] = $user->toJson();
                $dataLog['keterangan'] = "Berhasil login dengan username '".$request->username."'";
                log::create($dataLog);
                $request->session()->regenerate();
                return redirect('/user');
            }
        }

        // jika login gagal
        $dataLog['keterangan'] = "Mencoba login dengan username '".$request->username."'. Tetapi gagal karena username dan password salah.";
        log::create($dataLog);

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
