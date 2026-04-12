<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController; 
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --- ROUTES ADMINISTRATEUR ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Bienvenue sur le Tableau de Bord de l'Administrateur !";
    })->name('admin.dashboard');
});

// --- ROUTES MÉDECIN (Tes fonctionnalités + Rendez-vous) ---
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/medecin/dashboard', function () {
        return view('medecin.dashboard');
    })->name('medecin.dashboard');

    Route::resource('patients', PatientController::class);
    Route::resource('consultations', ConsultationController::class);
    Route::get('/consultations/{id}/pdf', [ConsultationController::class, 'generatePDF'])->name('consultations.pdf');
    
    // Rendez-vous Médecin
    Route::get('/medecin/appointments', [AppointmentController::class, 'medecinIndex'])->name('medecin.appointments');
});

//  ROUTES SECRÉTAIRE 
Route::middleware(['auth'])->prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'secretaireIndex'])->name('appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

//  ROUTES PATIENT
Route::middleware(['auth'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments');
});