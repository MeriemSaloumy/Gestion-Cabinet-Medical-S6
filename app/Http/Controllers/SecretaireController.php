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
        $patients = User::where('role', 'patient')->paginate(10); 

        $title = "Liste des Patients";
        
        return view('secretaire.patients.index', compact('patients'));
    }

    // Affiche le formulaire de création (C'est cette méthode qui manquait !)
    public function patientsCreate()
    {
        return view('secretaire.patients.create');
    }
 
    public function patientsStore(Request $request)
{
    // 1. Validation
    $validated = $request->validate([
        'nom'    => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'cin' => 'required',       // Ajoute la validation
        'telephone' => 'required', // Ajoute la validation
    ]);

    // 2. Enregistrement
    \App\Models\User::create([
        // ON UTILISE 'name' AU LIEU DE 'nom'/'prenom'
        'name'     => $request->nom . ' ' . $request->prenom, 
        'role'     => 'patient',
        'email'    => strtolower($request->nom . $request->prenom) . rand(10, 99) . '@clinic.com',
        'password' => bcrypt('password123'),
        'cin'     => $request->cin,
        'telephone' => $request->telephone,

    ]);

    // 3. Redirection
    return redirect()->route('secretaire.patients.index')->with('success', 'Le patient a été inscrit avec succès !');
}
    public function patientsEdit($id)
    {
    $patient = User::findOrFail($id); // Cherche le patient
    return view('secretaire.patients.edit', compact('patient')); // Renvoie vers la vue que tu vas créer
    }
    public function patientsUpdate(Request $request, $id)
{
    // 1. Validation
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
    ]);

    // 2. Trouver le patient
    $patient = User::findOrFail($id);

    // 3. Mise à jour (On fusionne nom et prénom pour la colonne 'name')
    $patient->update([
        'name' => $request->nom . ' ' . $request->prenom,
        'email' => $request->email,
    ]);

    // 4. Redirection
    return redirect()->route('secretaire.patients.index')
                     ->with('success', 'Informations du patient mises à jour !');
}
// Affiche le formulaire pour prendre un rendez-vous
public function appointmentsCreate()
{
    // On récupère uniquement les utilisateurs ayant le rôle 'patient'
    // On les trie par nom pour plus de clarté
    $patients = User::where('role', 'patient')->orderBy('name', 'asc')->get();

    // Si tu as besoin de la liste des médecins pour le formulaire
    $medecins = User::where('role', 'medecin')->get();

    return view('secretaire.appointments.create', compact('patients', 'medecins'));
}
public function appointmentsStore(Request $request)
{
    // 1. Validation stricte
    $request->validate([
        'patient_id' => 'required|exists:users,id',
        'medecin_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date',
        'motif' => 'nullable|string',
    ]);

    // 2. Création manuelle pour être sûr des colonnes
    \App\Models\Appointment::create([
        'user_id'          => $request->patient_id, // L'ID du patient va dans user_id
        'medecin_id'       => $request->medecin_id,
        'appointment_date' => $request->appointment_date,
        'motif'            => $request->motif,
        'status'           => 'en_attente',
    ]);

    return redirect()->route('secretaire.dashboard')->with('success', 'Rendez-vous créé !');
}
}