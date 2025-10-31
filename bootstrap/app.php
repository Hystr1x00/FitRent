<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\EnsureSuperAdmin::class,
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'user' => \App\Http\Middleware\EnsureUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 CSRF token expired errors specifically for logout
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            // If it's a logout request and session/CSRF token is expired, just redirect to login
            if ($request->is('logout') || $request->routeIs('logout')) {
                if (\Illuminate\Support\Facades\Auth::check()) {
                    \Illuminate\Support\Facades\Auth::logout();
                }
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Session telah berakhir. Silakan login kembali.');
            }
            
            // For other POST requests, redirect back with error message
            return back()->withInput()->with('error', 'Session telah berakhir. Silakan coba lagi.');
        });
    })->create();
