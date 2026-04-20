<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Mail\AppointmentConfirmed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Liste des rendez-vous pour la secrétaire (AVEC PAGINATION).
     */
    public function index()
    {
        // On récupère tous les rendez-vous, par exemple classés par date
        $appointments = Appointment::with(['patient', 'medecin']) // Charge aussi les infos du patient
                        ->select('appointments.*') 
                        ->distinct()
                        ->orderBy('appointment_date', 'asc')
                        ->paginate(10);

        return view('secretaire.appointments.index', compact('appointments'));
    }
   
    public function secretaireIndex(Request $request)
{
    $filter = $request->query('filter');
    $query = Appointment::with('patient', 'medecin'); // On charge les relations pour éviter les erreurs
    $title = "Tous les Rendez-vous";

    // Si on a cliqué sur "Rendez-vous du jour"
    if ($filter == 'today') {
        $query->whereDate('appointment_date', \Carbon\Carbon::today());
        $title = "Rendez-vous d'aujourd'hui (" . now()->format('d/m/Y') . ")";
    }

    $appointments = $query->orderBy('appointment_date', 'asc')->paginate(10);

    return view('secretaire.appointments.index', compact('appointments', 'title'));
}

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $patients = Patient::all();
        $medecins = User::where('role', 'medecin')->get();

        return view('secretaire.appointments.create', compact('patients', 'medecins'));
    }
    public function destroy(Appointment $appointment)
{
    // Suppression du rendez-vous
    $appointment->delete();

    // Redirection avec un message de succès
    return redirect()->route('secretaire.appointments.index')
                     ->with('success', 'Le rendez-vous a été supprimé avec succès.');
}
    /**
     * Enregistre le rendez-vous.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'motif' => 'nullable|string|max:255',
        ]);

        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'medecin_id' => $validated['medecin_id'],
            'appointment_date' => $validated['appointment_date'],
            'motif' => $validated['motif'],
            'status' => 'pending',
        ]);

        return redirect()->route('secretaire.appointments.index')
                         ->with('success', 'Rendez-vous enregistré avec succès !');
    }

    /**
     * Liste pour le médecin connecté.
     */
    public function medecinIndex()
    {
        $appointments = Appointment::where('medecin_id', Auth::id())
                                    ->with('patient')
                                    ->latest()
                                    ->paginate(10); // Aussi paginé pour le médecin

        return view('medecin.appointments', compact('appointments'));
    }

    public function confirm($id)
    {
    // On charge le RDV avec le patient ET son compte utilisateur (User)
    $appointment = Appointment::with('patient.user')->findOrFail($id);
    
    $appointment->status = 'confirmed';
    $appointment->save();

    // On cherche l'email : d'abord chez le patient, sinon chez l'utilisateur lié
    $destinataire = $appointment->patient->email ?? ($appointment->patient->user->email ?? null);

    if ($destinataire) {
        \Log::info('Envoi en cours vers : ' . $destinataire);
        
        Mail::to($destinataire)->send(new AppointmentConfirmed($appointment));
        
        \Log::info('Email enregistré dans le log !');
    } else {
        \Log::error('Email non envoyé : Pas d\'adresse trouvée pour le Patient ID ' . $appointment->patient_id);
    }

    return redirect()->back()->with('success', 'RDV confirmé et email envoyé !');
    }

    public function showPrescription($id)
    {
    // On récupère le rendez-vous AVEC sa prescription (Eager Loading)
    $appointment = Appointment::with('prescription', 'user', 'doctor')->findOrFail($id);

    // Vérification de sécurité pour toi (à supprimer après test)
    if (!$appointment->prescription) {
        return "Erreur : Aucune ordonnance n'est enregistrée pour ce rendez-vous en base de données.";
    }

    // On passe les données à la vue
    return view('patient.ordonnance_detail', [
        'appointment' => $appointment,
        'prescription' => $appointment->prescription // C'est cette variable qui contient les médicaments
    ]);
    }
}