<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\AppointmentController;

// Redirection par défaut après login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'medecin') {
        return redirect()->route('medecin.dashboard');
    }
    return redirect()->route('secretaire.dashboard');
})->middleware(['auth']);

// ROUTES MÉDECIN
Route::middleware(['auth'])->prefix('medecin')->group(function () {
    
    // Dashboard principal
    Route::get('/home', [MedecinController::class, 'index'])->name('medecin.dashboard');

    // Consultations (L'examen du patient)
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])->name('medecin.consultations.create');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('medecin.consultations.store');
    
    // Liste des patients (Dossiers)
    Route::get('/patients', [MedecinController::class, 'patientsIndex'])->name('medecin.patients.index');
});



// ROUTES SECRÉTAIRE
Route::middleware(['auth'])->prefix('secretaire')->group(function () {
    Route::get('/home', [SecretaireController::class, 'index'])->name('secretaire.dashboard');
    Route::resource('appointments', AppointmentController::class)->names('secretaire.appointments');
    
    // Les deux routes pour les patients :
    Route::get('/patients', [SecretaireController::class, 'patientsIndex'])->name('secretaire.patients.index');
    Route::get('/patients/create', [SecretaireController::class, 'patientsCreate'])->name('secretaire.patients.create'); // <--- AJOUTE CELLE-CI
    // AJOUTE CELLE-CI POUR L'ENREGISTREMENT :
    Route::post('/patients/store', [SecretaireController::class, 'patientsStore'])->name('secretaire.patients.store');
});

require __DIR__.'/auth.php';