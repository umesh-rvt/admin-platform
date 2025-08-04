<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has admin role or dashboard permission
        if (!$user->hasRole('admin') && !$user->hasPermission('dashboard.view')) {
            abort(403, 'Access denied. You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
