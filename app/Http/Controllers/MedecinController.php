<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Consultation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{
    /**
     * Dashboard du médecin : Stats, Recherche CIN et Agenda
     */


    public function index(Request $request)
{
    $today = \Carbon\Carbon::today();
    $filter = $request->query('filter'); 

    // Stats
    $rdvAujourdhui = \App\Models\Appointment::whereDate('appointment_date', $today)->count();
    $consultationsMois = \App\Models\Consultation::whereMonth('created_at', now()->month)->count();
    $totalPatientsSuivis = \App\Models\Patient::count();

    // Requête de base
    $query = \App\Models\Appointment::with('patient')->whereDate('appointment_date', $today);

    // FILTRE HARMONISÉ
    // Si on clique sur la carte rouge, on affiche tout sauf ce qui est 'termine'
    if ($filter == 'waiting') {
        $query->where('status', '!=', 'termine'); 
    }

    $fileAttente = $query->orderBy('appointment_date', 'asc')->get();

    return view('medecin.dashboard', compact(
        'rdvAujourdhui', 
        'consultationsMois', 
        'totalPatientsSuivis', 
        'fileAttente'
    ));
}
    /**
     * Formulaire pour créer une nouvelle consultation
     */
    public function createConsultation(Patient $patient)
    {
        return view('medecin.consultations.create', compact('patient'));
    }

    /**
     * Enregistrement de la consultation et de l'ordonnance
     */

   public function storeConsultation(Request $request)
{
    $validated = $request->validate([
        'patient_id'   => 'required|exists:users,id', // Assure-toi que c'est 'users' ou 'patients' selon ta table
        'diagnostic'   => 'required|string',
        'compte_rendu' => 'required|string', 
        'ordonnance'   => 'required|string',
        'tension'      => 'nullable|string',
        'poids'        => 'nullable|numeric',
    ]);

    $validated['user_id'] = Auth::id();

    // IMPORTANT : On stocke la consultation créée dans une variable
    $consultation = Consultation::create($validated);

    // Update du rendez-vous
    Appointment::where('patient_id', $request->patient_id)
               ->whereDate('appointment_date', \Carbon\Carbon::today())
               ->update(['status' => 'completed']); // Utilise le mot exact de ta migration

    // AU LIEU DE REDIRECT, ON AFFICHE LA VUE SHOW AVEC LES DONNÉES
    return view('medecin.consultations.show', compact('consultation'));
}
    /**
     * Affichage du dossier patient complet (Historique)
     */
    public function showPatientDossier(Patient $patient)
    {
        // On récupère toutes les consultations passées de ce patient
        $historique = Consultation::where('patient_id', $patient->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return view('medecin.patients.dossier', compact('patient', 'historique'));
    }

    /**
     * Génération de l'ordonnance en PDF
     */
    public function generatePDF($id)
    {
        $consultation = Consultation::with('patient')->findOrFail($id);
        
        // On charge une vue spécifique pour le design du PDF
        $pdf = Pdf::loadView('medecin.consultations.pdf', compact('consultation'));
        
        return $pdf->download('Ordonnance_' . $consultation->patient->nom . '.pdf');
    }
}