<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*if (Auth::guard($guard)->check()) {
            return redirect('admin/home');
        }*/
        switch($guard)
        {
            case 'client-web' : 
                if (Auth::guard($guard)->check()) {
                    return redirect('front/home');
                }
                break ;
            
            default : 
                if (Auth::guard($guard)->check()) {
                    return redirect('admin/home');
                }
                break ;
        }



        /*if($guard == 'client-web')
        {
            return redirect('front/home');
        }
        if($guard == 'web')
        {
            return redirect('admin/home');
        }*/
        
        return $next($request);
    }
}
