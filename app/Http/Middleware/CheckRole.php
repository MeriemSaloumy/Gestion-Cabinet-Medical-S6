<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Récupérer le nom du rôle de l'utilisateur
        $userRole = $user->role->name ?? null;

        // Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Redirection selon le rôle
        if ($userRole === 'medecin') {
            return redirect()->route('medecin.dashboard');
        } elseif ($userRole === 'secretaire') {
            return redirect()->route('secretaire.dashboard');
        } elseif ($userRole === 'patient') {
            return redirect()->route('patient.dashboard');
        }

        abort(403, 'Accès non autorisé.');
    }
}
