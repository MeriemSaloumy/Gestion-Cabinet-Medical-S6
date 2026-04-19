<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Affiche le formulaire de création de consultation
     */
    public function create($patient_id)
    {
        // On récupère les infos du patient pour les afficher sur la page
        $patient = User::findOrFail($patient_id);
        
        return view('medecin.consultations.create', compact('patient'));
    }

    /**
     * Enregistre la consultation et met à jour le rendez-vous
     */
    public function store(Request $request)
    {
        // 1. VALIDATION DES DONNÉES
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'diagnostic' => 'required|string',
            'ordonnance' => 'required|string',
        ]);

        // 2. ENREGISTREMENT DE LA CONSULTATION
        // On stocke le résultat dans la variable $consultation pour l'utiliser après
        $consultation = Consultation::create([
            'patient_id'   => $request->patient_id,
            'user_id'      => Auth::id(), // Le médecin connecté
            'diagnostic'   => $request->diagnostic,
            'ordonnance'   => $request->ordonnance,
            'compte_rendu' => $request->diagnostic, // On remplit par défaut avec le diagnostic
        ]);

        // 3. MISE À JOUR DU STATUT DU RENDEZ-VOUS
        // On cherche le rendez-vous "en attente" le plus récent pour ce patient
        $appointment = Appointment::where('patient_id', $request->patient_id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($appointment) {
            // On utilise 'completed' car c'est ce qui est défini dans ta migration
            $appointment->update([
                'status' => 'completed'
            ]);
        }

        // 4. REDIRECTION VERS LA VUE DE L'ORDONNANCE
        // Maintenant $consultation existe, donc compact('consultation') fonctionnera !
        return view('medecin.consultations.show', compact('consultation'));
    }
}