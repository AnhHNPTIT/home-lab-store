<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Customer;

class CheckUserLogin
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
        if(Auth::check()){
            $user = Auth::user();
            if ($user->status == 1 )
            {
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }
    }
}
