<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
{
    if (!Auth::check()) {
        return redirect('login');
    }

    $userRole = Auth::user()->role;

    if ($userRole == $role) {
        return $next($request);
    }

    // Si le rôle ne correspond pas, on redirige vers sa page par défaut
    switch ($userRole) {
        case 'admin':
            return redirect('/admin/dashboard');
        case 'medecin':
            return redirect('/medecin/dashboard');
        default:
            return redirect('/dashboard');
    }
}
}
