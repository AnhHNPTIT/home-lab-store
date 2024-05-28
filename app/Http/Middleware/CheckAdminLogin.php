<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('admin')->check()){
            $admin = Auth::guard('admin')->user();
            if ($admin->level == 1 && $admin->status == 1 )
            {
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect('/admin/login');
            }
        }
        else{
            return redirect('/admin/login');
        }
    }
}
