<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon; // Indispensable pour la gestion des dates

class PatientController extends Controller
{
    /**
     * Liste des patients avec filtres (Dashboard).
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $query = Patient::query();
        $title = "Liste de tous les Patients";

        // Filtre pour les nouveaux patients du mois actuel
        if ($filter == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            $title = "Nouveaux Patients du Mois";
        }

        $patients = $query->orderBy('nom', 'asc')->paginate(10);

        return view('secretaire.patients.index', compact('patients', 'title'));
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