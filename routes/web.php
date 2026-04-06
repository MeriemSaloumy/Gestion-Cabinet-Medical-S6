<?php

use App\Http\Controllers\ProfileController;
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
// --- TES ROUTES PERSONNALISÉES PAR RÔLE ---

// Routes réservées à l'Administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Bienvenue sur le Tableau de Bord de l'Administrateur !";
    })->name('admin.dashboard');
});

// Routes réservées au Médecin

// Routes réservées au Médecin
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/medecin/dashboard', function () {
        return view('medecin.dashboard'); // On change ici pour appeler la vue
    })->name('medecin.dashboard');
});