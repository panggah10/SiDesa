<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /*
        // Skip middleware for login route to prevent redirect loop
        if ($request->is('login')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $roleName = $user ? Role::find($user->role_id)->name : null;

        if (!$roleName || !in_array($roleName, $roles)) {
            return back();
        }
 */
        $roleName = Role::find(Auth::user()->role_id)->name;
        if (!Auth::check() || !in_array($roleName, $roles)) {
            return back();
        }
        return $next($request);
    }
}
