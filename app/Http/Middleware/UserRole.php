<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\ipModel;
use App\Models\log;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $ip = $request->ip();
        $checkIp = ipModel::where("username", $user->username)->where("ip", $ip)->get()->count();
        $role = $user->role;
        $menu = $user->aksesMenu;
        $active = $menu->where('status', true)->first();

        $mnUser = $menu->where('name', 'User')->first();
        $mnSite = $menu->where('name', 'Site')->first();
        $mnSiteData = $menu->where('name', 'Site Data')->first();

        $site = ['/','user','data-situs', 'gitpull'];
        $location = \Location::get($ip);
        $dataLog = [
            'class' => "middleware->UserRole",
            'name_activity' => "permision",
            'data_ip' => $ip,
            'data_location' => json_encode($location),
            'data_user' => $user->toJson(),
            'keterangan' => "Mencoba meng akses url '".$request->path()."'. Tetapi dikembalikan karena ip tidak terdaftar",
        ];

        if ($checkIp > 0) {
            if ($role->role_id != 4) {
                if ($active) {
                    if (in_array($request->path(), $site)) {
                        $dataLog["keterangan"] = "Berhasil meng akses url '".$request->path()."'";
                        log::create($dataLog);

                        return $next($request);
                    }else{
                        log::create($dataLog);
                        return redirect('/permision');
                    }
                }else{
                    log::create($dataLog);
                    return redirect('/permision');
                }
            }else{
                $dataLog["keterangan"] = "Berhasil meng akses url '".$request->path()."'";
                log::create($dataLog);
                return $next($request);
            }
        }else{
            log::create($dataLog);

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                "error" => "Your IP Address is not allowed login with your account, please contact SMB Spv. to add your IP $ip"
            ]);
        }

    }
}
