<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOfficerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->role->role_name, ['Admin', 'Teacher'])) {
            Auth::logout();
            return redirect()->route('officer.login')->withErrors([
                'email' => 'You do not have permission to access this area.',
            ]);
        }

        return $next($request);
    }
}
