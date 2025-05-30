<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleWare
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     //check if any of the provided roles exist in the UserRoles array
    //     if(array_intersect($roles, Auth:: user()->roles->pluck('role')->toArray())){
    //         return $next($request);
    //     }
    //     abort(403); //forbidden
    // }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): mixed
    {
        $user = session('user');
        if ($user->role === $role) {
            //dd(session('user_role'));
            return $next($request);
        }

        abort(403); // Forbidden
    }
}
