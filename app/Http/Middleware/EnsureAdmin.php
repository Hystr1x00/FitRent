<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     * Only allow users with role 'field_admin' or 'superadmin' to access admin routes
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // If not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }
        
        // If user (not admin), redirect to user dashboard
        if ($user->role === 'user' || $user->role === null) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Allow field_admin and superadmin
        if ($user->role !== 'field_admin' && $user->role !== 'superadmin') {
            abort(403, 'Unauthorized access. Only admins can access this page.');
        }

        return $next($request);
    }
}
