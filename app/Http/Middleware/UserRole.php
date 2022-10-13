<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        $role = auth()->user()->id_role;
        $menu = auth()->user()->aksesMenu;
        $active = $menu->where('status', true)->first();

        $mnUser = $menu->where('name', 'User')->first();
        $mnSite = $menu->where('name', 'Site')->first();
        $mnSiteData = $menu->where('name', 'Site Data')->first();

        if ($role != 1) {
            if ($active) {
                if (
                    $request->path() == '/' && $mnSite->status ||
                    $request->path() == 'user' && $mnUser->status ||
                    $request->path() == 'data-situs' && $mnSiteData->status
                ) {
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
    }
}
