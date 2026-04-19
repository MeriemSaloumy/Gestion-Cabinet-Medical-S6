<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\AppointmentController;

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
    }

    return view('dashboard'); // Vue par défaut pour les autres (ex: Patient)
})->middleware(['auth', 'verified'])->name('dashboard');


// ROUTES MÉDECIN
Route::middleware(['auth'])->prefix('medecin')->group(function () {
    
    // Dashboard principal
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
    
    // Gestion des rendez-vous (CRUD complet via resource)
    Route::resource('appointments', AppointmentController::class)->names('secretaire.appointments');
    
    // Gestion des patients côté secrétaire
    Route::get('/patients', [SecretaireController::class, 'patientsIndex'])->name('secretaire.patients.index');
    Route::get('/patients/create', [SecretaireController::class, 'patientsCreate'])->name('secretaire.patients.create');
    Route::post('/patients/store', [SecretaireController::class, 'patientsStore'])->name('secretaire.patients.store');
});

require __DIR__.'/auth.php';