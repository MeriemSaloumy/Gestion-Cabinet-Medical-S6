<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;

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
Route::middleware(['auth'])->prefix('medecin')->name('medecin.')->group(function () {
    
    // Dashboard : accessible via /medecin/home
    Route::get('/home', [MedecinController::class, 'index'])->name('dashboard');

    // Liste des patients : accessible via /medecin/patients
    Route::get('/patients', [MedecinController::class, 'patientsIndex'])->name('patients.index');

    // Dossier d'un patient : accessible via /medecin/patients/{patient}/dossier
    // On enlève le "/medecin" en trop car le prefix s'en occupe
    Route::get('/patients/{patient}/dossier', [MedecinController::class, 'showPatientDossier'])->name('patients.dossier'); 

    Route::get('/consultation/{id}/pdf', [MedecinController::class, 'generatePDF'])->name('ordonnance.pdf');

    // Consultations
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultations.store');
    
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

    Route::get('/patients/{id}/edit', [SecretaireController::class, 'patientsEdit'])->name('secretaire.patients.edit');
    Route::put('/patients/{id}', [SecretaireController::class, 'patientsUpdate'])->name('secretaire.patients.update');
});

// ROUTES PATIENT 
// Vérifie que ton middleware s'appelle bien 'role:patient' ou utilise juste 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [App\Http\Controllers\PatientController::class, 'index'])->name('patient.dashboard');
    }
);

require __DIR__.'/auth.php';