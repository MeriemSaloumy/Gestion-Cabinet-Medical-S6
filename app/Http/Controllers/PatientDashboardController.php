<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // On récupère les rendez-vous du patient connecté
        // On suppose que la relation 'appointments' existe dans le modèle User
        $rendezVous = $user->appointments()->orderBy('date_heure', 'asc')->get();

        // On récupère les consultations liées au patient
        // Note : Assure-vous que votre modèle User a une relation vers le Patient
        $consultations = [];
        if ($user->patient) {
            $consultations = $user->patient->consultations()->orderBy('created_at', 'desc')->get();
        }

        return view('patient.dashboard', compact('rendezVous', 'consultations'));
    }
}