<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUser
{
    /**
     * Handle an incoming request.
     * Only allow users with role 'user' or null to access user routes
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
        
        // If admin or superadmin, redirect to their respective dashboard
        if ($user->role === 'field_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Admin tidak dapat mengakses halaman user.');
        }
        
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.users.index')->with('error', 'Akses ditolak. Super Admin tidak dapat mengakses halaman user.');
        }
        
        // Only allow user role or null (default user)
        if ($user->role !== 'user' && $user->role !== null) {
            abort(403, 'Unauthorized access. Only users can access this page.');
        }

        return $next($request);
    }
}
