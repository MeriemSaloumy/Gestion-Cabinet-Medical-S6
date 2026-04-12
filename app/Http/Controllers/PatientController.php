<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // 1. On récupère le mot-clé tapé dans la barre de recherche
        $search = $request->input('query');

        // 2. On interroge la base de données avec Eloquent
        $patients = Patient::when($search, function ($query, $search) {
            return $query->where('nom', 'like', "%{$search}%")
                         ->orWhere('cin', 'like', "%{$search}%");
        })->get();

        // 3. On envoie les résultats à la vue
        return view('medecin.patients.index', compact('patients', 'search'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('medecin.patients.create');
    }

    // Enregistrer un nouveau patient
    public function store(Request $request)
    {
        // Validation (Crucial pour la sécurité et les points du projet !)
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|unique:patients,cin',
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient créé avec succès !');
    }

    public function show(Patient $patient)
    {
        // On charge le patient avec toutes ses consultations, triées par date
        $patient->load(['consultations' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('medecin.patients.show', compact('patient'));
    }

    // Modifier un patient (Formulaire)
    public function edit(Patient $patient)
    {
        return view('medecin.patients.edit', compact('patient'));
    }

    // Mettre à jour les infos
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'cin' => 'required|unique:patients,cin,' . $patient->id,
            'telephone' => 'required',
            'date_naissance' => 'required|date',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Fiche patient mise à jour !');
    }
}