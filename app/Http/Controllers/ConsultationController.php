<?php

namespace App\Http\Controllers;


use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class ConsultationController extends Controller
{
    // Affiche le formulaire pour une nouvelle consultation
    public function create(Request $request)
    {
        // On récupère l'ID du patient passé dans l'URL
        $patient = Patient::findOrFail($request->patient_id);
        
        return view('medecin.consultations.create', compact('patient'));
    }

    // Enregistre la consultation en base de données
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnostic' => 'required|string',
            'compte_rendu' => 'required|string',
        ]);

        Consultation::create([
          'patient_id' => $request->patient_id,
          'user_id' => auth()->id(), // On lie le médecin connecté
          'diagnostic' => $request->diagnostic,
          'compte_rendu' => $request->compte_rendu,
        ]);

        return redirect()->route('patients.show', $request->patient_id)
                         ->with('success', 'Consultation enregistrée !');
    }

    public function generatePDF($id)
    {
    // On récupère la consultation avec les infos du patient
    $consultation = \App\Models\Consultation::with('patient')->findOrFail($id);
    
    // On prépare le PDF à partir d'une vue qu'on va créer
    $pdf = Pdf::loadView('medecin.consultations.ordonnance_pdf', compact('consultation'));
    
    // On lance le téléchargement
    return $pdf->download('ordonnance_' . $consultation->patient->nom . '.pdf');
    }
}

