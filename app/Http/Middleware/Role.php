<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Config;


class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $userRole =Config::get('global.user_roles');

        if (!Auth::check()) 
            return redirect('login');
    
        $user = Auth::user();
    
        foreach($roles as $role) {
            if ($user->is_admin ==$userRole[$role] ) {
                return $next($request);
            }
        }
        return redirect('login');
    }
}
