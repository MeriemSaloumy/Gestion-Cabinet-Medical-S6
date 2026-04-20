<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Ce contrôleur gère l'authentification des utilisateurs pour l'application
    | et les redirige vers votre écran d'accueil. Le contrôleur utilise un trait
    | pour explorer facilement ses fonctionnalités.
    |
    */

    use AuthenticatesUsers;

    /**
     * Où rediriger les utilisateurs après la connexion.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // On récupère le rôle de l'utilisateur connecté
        $role = Auth::user()->role;

        // Redirection selon le rôle
        switch ($role) {
            case 'secretaire':
                return '/secretaire/home';
                break;
            case 'patient':
                return '/patient/dashboard';
                break;
            case 'medecin':
                return '/medecin/dashboard';
                break;
            default:
                return '/home';
                break;
        }
    }

    /**
     * Crée une nouvelle instance de contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}