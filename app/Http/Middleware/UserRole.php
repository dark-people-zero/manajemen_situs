<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\ipModel;

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

        if ($checkIp > 0) {
            if ($role->role_id != 4) {
                if ($active) {
                    if (in_array($request->path(), $site)) {
                        return $next($request);
                    }else{
                        return redirect('/permision');
                    }
                }else{
                    return redirect('/permision');
                }
            }else{
                return $next($request);
            }
        }else{
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                "error" => "Your IP Address is not allowed login with your account, please contact SMB Spv. to add your IP $ip"
            ]);
        }

    }
}
