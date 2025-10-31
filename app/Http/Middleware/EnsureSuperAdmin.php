<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // If not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }
        
        // If not superadmin, redirect based on role
        if ($user->role !== 'superadmin') {
            if ($user->role === 'field_admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
            }
            if ($user->role === 'user' || $user->role === null) {
                return redirect()->route('dashboard')->with('error', 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
            }
            abort(403, 'Unauthorized access. Only superadmin can access this page.');
        }

        return $next($request);
    }
}


