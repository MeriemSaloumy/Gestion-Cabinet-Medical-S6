<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. On récupère l'utilisateur qui vient de se connecter
        $user = Auth::user();

        // 2. L'AIGUILLAGE PAR RÔLE
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->role === 'medecin') {
            return redirect()->route('medecin.dashboard');
        }

        // AJOUT : Si c'est la secrétaire, on l'envoie vers son dashboard dédié
        if ($user->role === 'secretaire') {
            return redirect()->route('secretaire.dashboard');
        }

        // 3. Par défaut pour les patients ou autres
        return redirect()->intended(route('dashboard', absolute: false));
    }
////////
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
