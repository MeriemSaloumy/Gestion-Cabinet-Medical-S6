<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalPatients = Patient::count();
        $totalConsultations = Consultation::count();
        $totalMedecins = User::whereHas('role', function($query) {
            $query->where('name', 'medecin');
        })->count();
        $totalSecretaires = User::whereHas('role', function($query) {
            $query->where('name', 'secretaire');
        })->count();
        $totalRendezVous = Appointment::count();
        
        // Rendez-vous par mois pour le graphique (12 derniers mois)
        $rdvParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $count = Appointment::whereYear('appointment_date', $mois->year)
                               ->whereMonth('appointment_date', $mois->month)
                               ->count();
            $rdvParMois[] = [
                'mois' => $mois->format('M Y'),
                'total' => $count
            ];
        }
        
        // Consultations par mois pour le graphique (12 derniers mois)
        $consultationsParMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $count = Consultation::whereYear('created_at', $mois->year)
                                 ->whereMonth('created_at', $mois->month)
                                 ->count();
            $consultationsParMois[] = [
                'mois' => $mois->format('M Y'),
                'total' => $count
            ];
        }
        
        // Derniers rendez-vous
        $derniersRendezVous = Appointment::with('patient')
                                         ->orderBy('appointment_date', 'desc')
                                         ->limit(5)
                                         ->get();
        
        return view('admin.dashboard', compact(
            'totalPatients',
            'totalConsultations',
            'totalMedecins',
            'totalSecretaires',
            'totalRendezVous',
            'rdvParMois',
            'consultationsParMois',
            'derniersRendezVous'
        ));
    }
}