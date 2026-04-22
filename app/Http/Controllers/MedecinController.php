<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Consultation;
// use Barryvdh\DomPDF\Facade\Pdf;  // TEMPORAIREMENT DÉSACTIVÉ
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{
    /**
     * Dashboard du médecin
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $filter = $request->query('filter'); 

        $rdvAujourdhui = Appointment::whereDate('appointment_date', $today)->count();
        $consultationsMois = Consultation::whereMonth('created_at', now()->month)->count();
        $totalPatientsSuivis = Patient::count();

        $query = Appointment::with('patient')->whereDate('appointment_date', $today);

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
     * MÉTHODE MANQUANTE : Liste tous les patients (Dossiers)
     */
    public function patientsIndex(Request $request)
    {
        $search = $request->query('search');

        $query = Patient::query();

        // Si une recherche est effectuée, on filtre par nom, prenom ou cin
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                  ->orWhere('prenom', 'LIKE', "%{$search}%")
                  ->orWhere('cin', 'LIKE', "%{$search}%");
            });
        }

        // On récupère les patients avec pagination (10 par page)
        $patients = $query->orderBy('nom', 'asc')->paginate(10)->appends(request()->query());

        return view('medecin.patients.index', compact('patients'));
    }

    /**
     * Formulaire pour créer une nouvelle consultation
     */
    public function createConsultation(Patient $patient)
    {
        return view('medecin.consultations.create', compact('patient'));
    }

    /**
     * Enregistrement de la consultation
     */
    public function storeConsultation(Request $request)
    {
        $validated = $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'diagnostic'   => 'required|string',
            'compte_rendu' => 'required|string', 
            'ordonnance'   => 'required|string',
            'tension'      => 'nullable|string',
            'poids'        => 'nullable|numeric',
        ]);

        $validated['user_id'] = Auth::id();

        $consultation = Consultation::create($validated);

        // Update du rendez-vous en 'completed'
        Appointment::where('patient_id', $request->patient_id)
                   ->whereDate('appointment_date', Carbon::today())
                   ->update(['status' => 'completed']);

        return view('medecin.consultations.show', compact('consultation'));
    }

    /**
     * Affichage du dossier patient complet
     */
    public function showPatientDossier(Patient $patient)
    {
        $historique = Consultation::where('patient_id', $patient->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return view('medecin.patients.dossier', compact('patient', 'historique'));
    }

    /**
     * Génération de l'ordonnance en PDF
     * TEMPORAIREMENT DÉSACTIVÉ À CAUSE DE L'ERREUR DOMPDF
     */
    // public function generatePDF($id)
    // {
    //     $consultation = Consultation::with('patient')->findOrFail($id);
    //     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('medecin.consultations.ordonnance_pdf', compact('consultation'));
    //     return $pdf->download('Ordonnance_' . $consultation->patient->nom . '.pdf');
    // }

    // Version temporaire sans PDF
    public function generatePDF($id)
    {
        return "Fonction PDF temporairement désactivée. Veuillez réinstaller DomPDF.";
    }
}