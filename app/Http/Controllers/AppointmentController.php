<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Vue pour le secrétaire
    public function secretaireIndex()
    {
        $appointments = Appointment::with(['patient', 'medecin'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        
        $medecins = User::where('role', 'medecin')->get();
        $patients = User::where('role', 'patient')->get();
        
        return view('secretaire.appointments', compact('appointments', 'medecins', 'patients'));
    }

    // Formulaire de création
    public function create()
    {
        $medecins = User::where('role', 'medecin')->get();
        $patients = User::where('role', 'patient')->get();
        return view('secretaire.create-appointment', compact('medecins', 'patients'));
    }

    // Stocker un nouveau rendez-vous
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medecin_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'motif' => 'nullable|string|max:255',
        ]);

        // Vérifier si le créneau est disponible
        $existing = Appointment::where('medecin_id', $request->medecin_id)
            ->where('appointment_date', $request->appointment_date)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($existing) {
            return back()->withErrors(['appointment_date' => 'Ce créneau est déjà pris'])->withInput();
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'appointment_date' => $request->appointment_date,
            'motif' => $request->motif,
            'status' => 'confirmed',
            'notes' => $request->notes,
        ]);

        $this->sendConfirmationEmail($appointment);

        return redirect()->route('secretaire.appointments')
            ->with('success', 'Rendez-vous créé avec succès !');
    }

    // Annuler un rendez-vous
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        
        $this->sendCancellationEmail($appointment);

        return redirect()->route('secretaire.appointments')
            ->with('success', 'Rendez-vous annulé avec succès !');
    }

    // Vue médecin pour ses rendez-vous
    public function medecinIndex()
    {
        $appointments = Appointment::with('patient')
            ->where('medecin_id', Auth::id())
            ->whereDate('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pastAppointments = Appointment::with('patient')
            ->where('medecin_id', Auth::id())
            ->whereDate('appointment_date', '<', now())
            ->orderBy('appointment_date', 'desc')
            ->limit(20)
            ->get();

        return view('medecin.appointments', compact('appointments', 'pastAppointments'));
    }

    // Vue patient pour ses rendez-vous
    public function patientIndex()
    {
        $upcomingAppointments = Appointment::with('medecin')
            ->where('patient_id', Auth::id())
            ->whereDate('appointment_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date', 'asc')
            ->get();

        $pastAppointments = Appointment::with('medecin')
            ->where('patient_id', Auth::id())
            ->where(function($q) {
                $q->whereDate('appointment_date', '<', now())
                  ->orWhere('status', 'cancelled');
            })
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.appointments', compact('upcomingAppointments', 'pastAppointments'));
    }

    private function sendConfirmationEmail(Appointment $appointment)
    {
        $patient = $appointment->patient;
        $medecin = $appointment->medecin;
        
        Mail::send('emails.appointment-confirmation', [
            'patient' => $patient,
            'medecin' => $medecin,
            'appointment' => $appointment
        ], function ($message) use ($patient) {
            $message->to($patient->email)
                    ->subject('Confirmation de votre rendez-vous');
        });
    }

    private function sendCancellationEmail(Appointment $appointment)
    {
        Mail::send('emails.appointment-cancelled', [
            'appointment' => $appointment
        ], function ($message) use ($appointment) {
            $message->to($appointment->patient->email)
                    ->subject('Annulation de votre rendez-vous');
        });
    }
}