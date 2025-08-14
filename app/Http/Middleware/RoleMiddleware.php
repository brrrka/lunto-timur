<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $role = Role::find($user->role_id);

        // Jika role tidak ditemukan
        if (!$role || !in_array($role->name, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
