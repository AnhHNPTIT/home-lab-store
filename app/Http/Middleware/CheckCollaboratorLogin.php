<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckCollaboratorLogin
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
            if ($admin->level == 0 && $admin->status == 1 )
            {
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect('/collaborator/login');
            }
        }
        else{
            return redirect('/collaborator/login');
        }
    }
}
