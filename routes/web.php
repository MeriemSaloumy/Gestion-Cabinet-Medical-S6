<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientDashboardController;

// Accueil
Route::get('/', function () {
    return view('welcome');
});

// Redirection intelligente après login
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'medecin') {
        return redirect()->route('medecin.dashboard');
    } elseif ($role === 'secretaire') {
        return redirect()->route('secretaire.dashboard');
    } elseif ($role === 'patient') {
        return redirect()->route('patient.dashboard'); // Redirection pour le patient ajoutée
    }

    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');


// ROUTES MÉDECIN
Route::middleware(['auth'])->prefix('medecin')->group(function () {
    
    Route::get('/home', [MedecinController::class, 'index'])->name('medecin.dashboard');

    // Consultations
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])->name('medecin.consultations.create');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('medecin.consultations.store');
    
    // Liste des patients (Dossiers)
    Route::get('/patients', [MedecinController::class, 'patientsIndex'])->name('medecin.patients.index');
});


// ROUTES SECRÉTAIRE
Route::middleware(['auth'])->prefix('secretaire')->group(function () {
    
    // Dashboard
    Route::get('/home', [SecretaireController::class, 'index'])->name('secretaire.dashboard');
    
    // Gestion des rendez-vous
    // On ajoute la route de confirmation AVANT la ressource pour être sûr qu'elle soit prioritaire
    Route::patch('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::resource('appointments', AppointmentController::class)->names('secretaire.appointments');
    
    // Gestion des patients côté secrétaire
    Route::get('/patients', [SecretaireController::class, 'patientsIndex'])->name('secretaire.patients.index');
    Route::get('/patients/create', [SecretaireController::class, 'patientsCreate'])->name('secretaire.patients.create');
    Route::post('/patients/store', [SecretaireController::class, 'patientsStore'])->name('secretaire.patients.store');
});

// ROUTES PATIENT 
// Vérifie que ton middleware s'appelle bien 'role:patient' ou utilise juste 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
});

require __DIR__.'/auth.php';