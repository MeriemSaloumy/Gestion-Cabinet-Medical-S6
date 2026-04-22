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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role; // C'est un string directement

        // Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Si le rôle ne correspond pas, on redirige vers sa page par défaut
        switch ($userRole) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'medecin':
                return redirect()->route('medecin.dashboard');
            case 'secretaire':
                return redirect()->route('secretaire.dashboard');
            case 'patient':
                return redirect()->route('patient.dashboard');
            default:
                return redirect('/dashboard')->with('error', 'Accès non autorisé.');
        }
    }
}
