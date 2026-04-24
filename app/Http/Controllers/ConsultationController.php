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
    $request->validate([
        'patient_id' => 'required|exists:users,id',
        'diagnostic' => 'required|string',
        'ordonnance' => 'required|string',
    ]);

    // ÉTAPE A : Désactiver les contraintes de clés étrangères pour SQLite
    \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF');

    // ÉTAPE B : Ton code d'enregistrement actuel
    $consultation = Consultation::create([
        'patient_id'   => $request->patient_id,
        'user_id'      => Auth::id(), 
        'diagnostic'   => $request->diagnostic,
        'ordonnance'   => $request->ordonnance,
        'compte_rendu' => $request->diagnostic,
    ]);

    // ÉTAPE C : Réactiver les contraintes
    \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON');

    // La suite de ton code (Mise à jour Appointment)...
    $appointment = Appointment::where('patient_id', $request->patient_id)
        ->where('status', 'pending')
        ->latest()
        ->first();

    if ($appointment) {
        $appointment->update(['status' => 'completed']);
    }
    // AJOUTEZ CETTE LIGNE : 
   $consultation->load('patient'); 


    return view('medecin.consultations.show', compact('consultation'));
}}