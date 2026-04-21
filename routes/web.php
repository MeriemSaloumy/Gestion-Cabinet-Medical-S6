<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;

// Accueil
Route::get('/', function () {
    return view('welcome');
});

// Redirection intelligente après login
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'medecin') {
        return redirect()->route('medecin.dashboard');
    } elseif ($role === 'secretaire') {
        return redirect()->route('secretaire.dashboard');
    } elseif ($role === 'patient') {
        return redirect()->route('patient.dashboard');
    }

    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// ROUTES MÉDECIN
Route::middleware(['auth'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/home', [MedecinController::class, 'index'])->name('dashboard');
    Route::get('/patients', [MedecinController::class, 'patientsIndex'])->name('patients.index');
    Route::get('/patients/{patient}/dossier', [MedecinController::class, 'showPatientDossier'])->name('patients.dossier'); 
    Route::get('/consultation/{id}/pdf', [MedecinController::class, 'generatePDF'])->name('ordonnance.pdf');
    Route::get('/consultation/create/{patient_id}', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultations.store');
});

// ROUTES SECRÉTAIRE
Route::middleware(['auth'])->prefix('secretaire')->group(function () {
    Route::get('/home', [SecretaireController::class, 'index'])->name('secretaire.dashboard');
    Route::patch('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::resource('appointments', AppointmentController::class)->names('secretaire.appointments');
    Route::get('/patients', [SecretaireController::class, 'patientsIndex'])->name('secretaire.patients.index');
    Route::get('/patients/create', [SecretaireController::class, 'patientsCreate'])->name('secretaire.patients.create');
    Route::post('/patients/store', [SecretaireController::class, 'patientsStore'])->name('secretaire.patients.store');
    Route::get('/patients/{id}/edit', [SecretaireController::class, 'patientsEdit'])->name('secretaire.patients.edit');
    Route::put('/patients/{id}', [SecretaireController::class, 'patientsUpdate'])->name('secretaire.patients.update');
});

// ROUTES PATIENT
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [App\Http\Controllers\PatientController::class, 'index'])->name('patient.dashboard');
});

// ROUTES ADMINISTRATEUR
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminController::class);
});

require __DIR__.'/auth.php';