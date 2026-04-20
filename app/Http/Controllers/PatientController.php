<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Indispensable pour la gestion des dates

class PatientController extends Controller
{
    /**
     * Liste des patients avec filtres (Dashboard).
     */
    public function index(Request $request)
    {
        $user = auth()->user(); 
    
    // 1. Récupérer les rendez-vous
    $rendezVous = \App\Models\Appointment::where('patient_id', $user->id)
                    ->orderBy('appointment_date', 'asc')
                    ->get();

    // 2. Récupérer les consultations (Dossiers médicaux)
    // Si tu n'as pas encore de table consultations, on envoie un tableau vide pour éviter l'erreur
    $consultations = []; 
    
    /* Dès que tu auras une table Consultation, tu pourras utiliser :
       $consultations = \App\Models\Consultation::where('patient_id', $user->id)->get();
    */

    // On envoie TOUTES les variables nécessaires à la vue
    return view('patient.dashboard', [
        'patient' => $user,
        'rendezVous' => $rendezVous,
        'consultations' => $consultations
    ]);
    }

    // Tu peux supprimer la fonction dashboard() si elle fait doublon avec index()
    // ou la mettre à jour avec le même nom de variable :
    public function dashboard()
    {
        $rendezVous = Appointment::where('patient_id', Auth::id())
                        ->orderBy('appointment_date', 'asc')
                        ->get();

        return view('patient.dashboard', compact('rendezVous'));
    }

    public function create()
    {
        return view('secretaire.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'cin'            => 'required|string|unique:patients,cin',
            'telephone'      => 'required|string',
            'date_naissance' => 'required|date',
            'sexe'           => 'required|in:M,F',
            'email'          => 'nullable|email', // Ajouté car présent dans ton formulaire
            'adresse'        => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('secretaire.dashboard')
                         ->with('success', 'Le patient ' . $request->nom . ' a été inscrit avec succès !');
    }

    public function show(Patient $patient)
    {
        $patient->load('appointments'); 
        return view('secretaire.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('secretaire.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'cin'            => 'required|string|unique:patients,cin,' . $patient->id,
            'telephone'      => 'required|string',
            'date_naissance' => 'required|date',
            'sexe'           => 'required|in:M,F',
            'email'          => 'nullable|email',
            'adresse'        => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('secretaire.patients.index')
                         ->with('success', 'Fiche patient mise à jour avec succès.');
    }
}