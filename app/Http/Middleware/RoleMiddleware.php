<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();

            // Check if user exists and has a role
            if (!$user || !$user->role) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['error' => 'Invalid user session.']);
            }

            $userRole = $user->role->name;

            // Check if user role is allowed
            if (!in_array($userRole, $roles)) {
                Log::warning('RoleMiddleware: Access denied', [
                    'user_id' => $user->id,
                    'user_role' => $userRole,
                    'required_roles' => $roles,
                    'route' => $request->route()->getName()
                ]);

                // Redirect to appropriate dashboard instead of showing 403
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('RoleMiddleware error: ' . $e->getMessage());
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'Session error. Please login again.']);
        }
    }
}