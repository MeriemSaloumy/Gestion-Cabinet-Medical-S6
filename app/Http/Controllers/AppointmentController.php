<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Liste des rendez-vous pour la secrétaire (AVEC PAGINATION).
     */
   
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
}