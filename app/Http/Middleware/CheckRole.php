<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;
    
            $roles = array_slice(func_get_args(), 2);
    
            foreach ($roles as $role) {
                if ($userRole == $role) {
                    return $next($request);
                }
            }
            return redirect('/');
        }
        return redirect('/login');
    }
    
}
