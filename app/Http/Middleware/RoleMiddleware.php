<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * $role can be 'admin', 'seller', 'user'
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();

        if(!$user){
            abort(403, 'Unauthorized'); // Not logged in
        }

        // Block inactive users
        if(!$user->is_active){
            abort(403, 'Your account is blocked.');
        }

        // Role-based access
        switch($role){
            case 'admin':
                if(!$user->is_admin){
                    abort(403, 'Unauthorized - Admins only');
                }
                break;

            case 'seller':
                if(!$user->is_seller){
                    abort(403, 'Unauthorized - Sellers only');
                }
                break;

            case 'user':
                if($user->is_admin || $user->is_seller){
                    abort(403, 'Unauthorized - Buyers only');
                }
                break;

            default:
                abort(403, 'Unauthorized'); // Invalid role
        }

        return $next($request);
    }
}
