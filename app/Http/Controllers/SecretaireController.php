<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User; // Utilisation de User pour les patients
use Carbon\Carbon;

class SecretaireController extends Controller
{
    public function index()
    {
        // On compte les rendez-vous d'aujourd'hui
        $countToday = Appointment::whereDate('appointment_date', Carbon::today())->count();

        // On compte le total des patients (ceux qui ont le rôle 'patient')
        $countPatients = User::where('role', 'patient')->count();

        // On compte les nouveaux patients inscrits ce mois-ci
        $countMonth = User::where('role', 'patient')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->count();

        return view('secretaire.dashboard', compact('countToday', 'countPatients', 'countMonth'));
    }

    // Affiche la liste des patients
    public function patientsIndex()
    {
        $patients = User::where('role', 'patient')->get(); 
        
        return view('secretaire.patients.index', compact('patients'));
    }

    // Affiche le formulaire de création (C'est cette méthode qui manquait !)
    public function patientsCreate()
    {
        return view('secretaire.patients.create');
    }
    public function patientsStore(Request $request)
{
    // 1. Validation dial l-m3loumat li jaw mn l-formulaire
    $validated = $request->validate([
        'nom'    => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        // zid ay haja khra dertiha f l-formulaire (ex: telephone, cin...)
    ]);

    // 2. Enregistrement f la base de données
    // Hna kan'creer un Patient (ou User m3a role patient)
    \App\Models\User::create([
        'name'     => $request->nom . ' ' . $request->prenom,
        'nom'      => $request->nom,
        'prenom'   => $request->prenom,
        'role'     => 'patient',
        'email'    => strtolower($request->nom . $request->prenom) . rand(10, 99) . '@clinic.com',
        'password' => bcrypt('password123'), // Password par défaut
    ]);

    // 3. Redirection l la liste dial les patients m3a message de succès
    return redirect()->route('secretaire.patients.index')->with('success', 'Le patient a été inscrit avec succès !');
}
}